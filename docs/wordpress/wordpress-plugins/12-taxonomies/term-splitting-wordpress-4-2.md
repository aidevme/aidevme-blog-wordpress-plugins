# Term Splitting (WordPress 4.2)

Reference: <https://developer.wordpress.org/plugins/taxonomies/split-terms-wp-4-2/>

## Overview

This information is here for historical purposes; if you're not interested in how terms worked prior to 2015, you can skip this section.

## Prior to WordPress 4.2

Terms in different taxonomies with the same slug shared a single term ID. For instance, a tag and a category with the slug "news" had the same term ID.

## WordPress 4.2+

Beginning with 4.2, when one of these shared terms is updated, it is split: the updated term is assigned a new term ID.

## What does it mean for you?

In the vast majority of situations, this update was seamless and uneventful. However, some plugins and themes that store term IDs in options, post meta, user meta, or elsewhere may have been affected.

## Handling the Split

WordPress 4.2 includes two different tools to help plugin and theme authors with the transition.

### The `split_shared_term` hook

When a shared term is assigned a new term ID, a new `split_shared_term` action is fired. Using this hook is the preferred method for processing term ID changes.

For example, if a plugin stores an option called `featured_tags` containing an array of term IDs used to query featured posts, it can hook `split_shared_term` to check whether the updated term ID is in that array and update it if necessary:

```php
/**
 * Update featured_tags option when a shared term gets split.
 *
 * @param int    $term_id          ID of the formerly shared term.
 * @param int    $new_term_id      ID of the new term created for the $term_taxonomy_id.
 * @param int    $term_taxonomy_id ID for the term_taxonomy row affected by the split.
 * @param string $taxonomy         Taxonomy for the split term.
 */
function wporg_featured_tags_split( int $term_id, int $new_term_id, int $term_taxonomy_id, string $taxonomy ): void {
    // we only care about tags, so we'll first verify that the taxonomy is post_tag.
    if ( 'post_tag' === $taxonomy ) {

        // get the currently featured tags.
        $featured_tags = get_option( 'featured_tags' );

        // if the updated term is in the array, note the array key.
        $found_term = array_search( $term_id, $featured_tags, true );
        if ( false !== $found_term ) {

            // the updated term is a featured tag! replace it in the array, save the new array.
            $featured_tags[ $found_term ] = $new_term_id;
            update_option( 'featured_tags', $featured_tags );
        }
    }
}
add_action( 'split_shared_term', 'wporg_featured_tags_split', 10, 4 );
```

Similarly, a plugin storing a term ID in post meta (for example, to show related posts for a page) can use `get_posts()` to find the affected pages and update the stored meta value:

```php
/**
 * Update related posts term ID for pages
 *
 * @param int    $term_id          ID of the formerly shared term.
 * @param int    $new_term_id      ID of the new term created for the $term_taxonomy_id.
 * @param int    $term_taxonomy_id ID for the term_taxonomy row affected by the split.
 * @param string $taxonomy         Taxonomy for the split term.
 */
function wporg_page_related_posts_split( int $term_id, int $new_term_id, int $term_taxonomy_id, string $taxonomy ): void {
    // find all the pages where meta_value matches the old term ID.
    $page_ids = get_posts(
        array(
            'post_type'  => 'page',
            'fields'     => 'ids',
            'meta_key'   => 'meta_key',
            'meta_value' => $term_id,
        )
    );

    // if such pages exist, update the term ID for each page.
    if ( $page_ids ) {
        foreach ( $page_ids as $id ) {
            update_post_meta( $id, 'meta_key', $new_term_id, $term_id );
        }
    }
}
add_action( 'split_shared_term', 'wporg_page_related_posts_split', 10, 4 );
```

### The `wp_get_split_term()` function

There may be cases where terms are split without your plugin having a chance to hook `split_shared_term`. WordPress 4.2 stores information about split taxonomy terms and provides `wp_get_split_term()` to retrieve it — useful, for example, in a validation routine run on plugin update:

```php
/**
 * Retrieve information about split terms and update the featured_tags option with the new term IDs.
 *
 * @return void
 */
function wporg_featured_tags_check_split() {
    $featured_tag_ids = get_option( 'featured_tags', array() );

    // check to see whether any IDs correspond to post_tag terms that have been split.
    foreach ( $featured_tag_ids as $index => $featured_tag_id ) {
        $new_term_id = wp_get_split_term( $featured_tag_id, 'post_tag' );

        if ( $new_term_id ) {
            $featured_tag_ids[ $index ] = $new_term_id;
        }
    }

    // save
    update_option( 'featured_tags', $featured_tag_ids );
}
```

`wp_get_split_term()` takes two parameters, `$old_term_id` and `$taxonomy`, and returns an integer. To retrieve a list of all split terms associated with an old term ID regardless of taxonomy, use `wp_get_split_terms()`.
