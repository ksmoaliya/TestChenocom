<?php
$args = [
    'post_type'      => 'agenda',
    'posts_per_page' => $number,
    'orderby'        => 'date',
    'order'          => 'ASC'
];

$query = new WP_Query($args);

$featured_post = null;
$events = [];
?>

<div class="agenda-block">

    <!-- HEADER -->
    <header class="header-agenda container">
        <div class="logo-container">
            <div class="icon-circle">
                <div class="icon-dot"></div>
            </div>
            <?php if (!empty($title)) : ?>
            <h1 class="title-agenda font-black tracking-tighter">
                <?php echo esc_html($title); ?>
            </h1>
            <?php endif; ?>
        </div>
         <nav class="nav-tags">
                <?php
                $categories = get_terms([
                    'taxonomy'   => 'agenda_category',
                    'hide_empty' => false,
                ]);

                if (!empty($categories) && !is_wp_error($categories)) :
                    foreach ($categories as $term) : ?>
                        <button class="nav-tag uppercase">
                            <?php echo esc_html($term->name); ?>
                        </button>
                    <?php endforeach;
                endif;
                ?>
            </nav>
    </header>

    <?php if ($query->have_posts()) : ?>

        <?php
        // prépare les données
        while ($query->have_posts()) : $query->the_post();

            $fields = get_fields();

            $event = [
                'title'          => get_the_title(),
                'link'           => get_permalink(),
                'date_debut'     => format_agenda_date($fields['date_debut'] ?? ''),
                'date_fin'       => format_agenda_date($fields['date_fin'] ?? ''),
                'prochaine_date' => format_agenda_date($fields['prochaine_date'] ?? '', 'd/m/Y'),
                'image'          => $fields['image'] ?? null,
                'lieu'           => $fields['lieu'] ?? '',
                'ville'          => $fields['ville'] ?? '',
                'featured'       => !empty($fields['featured_post']),
                'category'       => get_the_terms(get_the_ID(), 'agenda_category'),
            ];

            if ($event['featured'] && !$featured_post) {
                $featured_post = $event;
            } else {
                $events[] = $event;
            }

        endwhile;
        ?>

        <!-- FEATURED -->
        <?php if ($featured_post) : ?>
            <section class="featured-section">
                <div class="container">
                    <div class="featured-container">

                        <div class="featured-content">
                            <div class="featured-dates uppercase">
                                <span><?php echo esc_html($featured_post['date_debut']); ?></span>
                                <i class="fa-solid fa-arrow-right"></i>
                                <span><?php echo esc_html($featured_post['date_fin']); ?></span>
                            </div>

                            <span class="featured-category uppercase">
                                <?php echo esc_html($featured_post['category'][0]->name ?? ''); ?>
                            </span>

                            <h2 class="featured-title uppercase">
                                <a href="<?php echo esc_html($featured_post['link']); ?>" title=""><?php echo esc_html($featured_post['title']); ?></a>
                            </h2>

                            <div class="separator-line"></div>

                            <div class="featured-footer uppercase">
                                <div>Prochaine date : <?php echo esc_html($featured_post['prochaine_date']); ?></div>
                                <div>
                                    <?php echo esc_html($featured_post['lieu'] . ' - ' . $featured_post['ville']); ?>
                                </div>
                            </div>
                        </div>

                        <div class="featured-image-wrapper">
                            <div>
                            <?php if (!empty($featured_post['image'])) : ?>
                                <img src="<?php echo esc_url($featured_post['image']['url']); ?>" alt="" loading="lazy">
                            <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- GRID -->
        <section class="container">
            <div class="grid-section">

                <?php foreach ($events as $event) : ?>
                    <article class="event-card">

                        <div class="card-content">
                            <div class="card-group">
                                <?php if (!empty($event['image'])) : ?>
                                    <div class="card-image">
                                        <img src="<?php echo esc_url($event['image']['url']); ?>" alt="" loading="lazy">
                                    </div>
                                <?php endif; ?>
                                <div class="card-date uppercase">
                                    <span><?php echo esc_html($event['date_debut']); ?></span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                    <span><?php echo esc_html($event['date_fin']); ?></span>
                                </div>
                            </div>

                            <span class="card-category uppercase">
                                <?php echo esc_html($event['category'][0]->name ?? ''); ?>
                            </span>

                            <h3 class="card-title uppercase">
                                <a href="<?php echo esc_html($event['link']); ?>" title=""><?php echo esc_html($event['title']); ?></a>
                            </h3>

                            <div class="separator-line black"></div>

                            <div class="card-footer uppercase">
                                <span>Prochaine date : <?php echo esc_html($event['prochaine_date']); ?></span>
                                <span><?php echo esc_html($event['lieu']); ?></span>
                                <span><?php echo esc_html($event['ville']); ?></span>
                            </div>

                        </div>
                    </article>
                <?php endforeach; ?>

            </div>

            <div class="footer-actions">
                <a class="btn-primary uppercase" href="<?php echo esc_url(get_post_type_archive_link('agenda')); ?>">
                    <i class="fa-solid fa-plus"></i> Tous les événements
                </a>
            </div>
        </section>

    <?php else : ?>
        <p>Aucun événement</p>
    <?php endif; ?>

</div>

<?php wp_reset_postdata(); ?>