<?php
    get_header();
    $adverts = get_posts(['post_type'=>'adverts']);
?>

    <div class="row">
        <?php if(count($adverts)): ?>
            <?php foreach($adverts as $advert): ?>
                <div style="margin-bottom: 20px;" class="col-md-4">
                    <div class="card">
                        <img style="" class="card-img-top" src="<?= get_the_post_thumbnail_url($advert) ?>" alt="<?= $advert->post_title ?>">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $advert->post_title ?>
                            </h5>
                            <p class="card-text">
                                <?= substr($advert->post_content, 0, 120).'...' ?>
                            </p>
                            
                            <a href="<?= home_url().'/ad/?id='. $advert->ID ?>" class="btn btn-block btn-primary">Detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            Nenhum resultado encontrado
        <?php endif ?>
    </div>

<?php get_footer(); ?>