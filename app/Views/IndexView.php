<div class="row mt-3 justify-content-center">

    <div class="marquee">
        <p><b>Guten Tag!</b> Eine Waldorfschule (auch: Rudolf-Steiner-Schule und in Deutschland Freie Waldorfschule)
            ist eine Schule, an der nach der von Rudolf Steiner (1861–1925) begründeten Waldorfpädagogik unterrichtet
            wird. Die Waldorfpädagogik beruht auf der anthroposophischen Menschenkunde von Rudolf Steiner. In
            Deutschland sind Waldorfschulen staatlich genehmigte oder staatlich anerkannte Ersatzschulen in freier
            Trägerschaft. Seit der zweiten Hälfte des 20. Jahrhunderts werden Waldorfschulen auch in anderen Ländern
            aufgebaut. Nach Angaben des Bundes der Freien Waldorfschulen mit Stand vom Mai 2020 gibt es weltweit 1214
            Waldorfschulen. Die meisten von ihnen befinden sich in Deutschland (252), gefolgt von den USA (123) und den
            Niederlanden (115). In der Schweiz gibt es 32 und in Österreich 21 Waldorfschulen. Die meisten
            Waldorfschulen im Verhältnis zur Einwohnerzahl sind in Estland (10). Nach dem Ende der Sowjetunion
            entstanden in Russland 20 Waldorfschulen.</p>
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