<div class="row mt-3 justify-content-center">

    <div class="marquee">
        <p><b>Guten Tag!</b> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
            ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
            ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum
            dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore
            magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita
            kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
    </div>

    <div class="col-lg-12">
        <?= !empty(session('error')) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('index.error') . '</b> ' . session('error') . '</div>' : '' ?>

        <div class="row">
            <?php
            foreach ($entries as $entry) {
                echo '<div class="col-sm-4 mt-3">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $entry->name . '</h5>';
                echo '<p class="card-text">' . $entry->description . '</p>';
                foreach ($entry->buttons as $button) {
                    echo '<a href="' . $button->url . '" target="_blank" class="btn btn-' . $button->color->value . '" style="margin-right: 10px">' . $button->name . '</a>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>