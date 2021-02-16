<?php
    /* Template Name: detail_page */
    get_header();
    $advert = get_post($_REQUEST['id']);
?>

    <div class="card col-md-12">
        <?php if ($advert != null AND $advert->post_type == 'adverts'): ?>
            <img style="" class="card-img-top" src="<?= get_the_post_thumbnail_url($advert) ?>" alt="<?= $advert->post_title ?>">
            <div class="card-body">
                <h5 class="card-title">
                    <?= $advert->post_title ?>
                </h5>
                <p class="card-text">
                    <?= nl2br($advert->post_content) ?>
                </p>
            </div>
        <?php else: ?>
            Nenhum resultado encontrado
        <?php endif ?>
    </div>
<?php get_footer(); ?>