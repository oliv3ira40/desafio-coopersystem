<?php
    get_header();

    if (isset($_GET['filter'])) {
        $args = [
            'post_type' => 'adverts',
            's' => $_GET['filter'],
            'order' => $_GET['order'],
            'tax_query' => [
                'taxonomy' => 'post_tag',
                'field' => 'slug',
                'terms' => $_GET['filter'],
            ]
        ];
        $adverts = get_posts($args);
    } else {
        $adverts = get_posts(['post_type'=>'adverts', 'numberposts' => 20]);
    }
?>

    <div class="row">
        <div style="margin-bottom: 20px;" class="col-md-6">
            <label for="filter">Buscar anúncio</label>
            <form class="form-inline my-2 my-lg-0" action="<?= home_url(); ?>" method="get">
                <input class="form-control mr-sm-2" name="filter" id="filter" type="search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    Buscar
                </button>
            </form>
        </div>
        <div style="margin-bottom: 20px;" class="col-md-6">
            <label for="select_order">Ordem de exibição</label>
            <select class="form-control" id="select_order" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="">Selecione...</option>
                <option value="<?= home_url().'/?filter='.$_GET['filter'].'&order=desc' ?>">Desc</option>
                <option value="<?= home_url().'/?filter='.$_GET['filter'].'&order=asc' ?>">Asc</option>
            </select>
        </div>
    </div>

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
                            
                            <a href="<?= home_url().'/detalhe/?id='. $advert->ID ?>" class="btn btn-block btn-primary">Detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            Nenhum resultado encontrado
        <?php endif ?>
    </div>

<?php get_footer(); ?>