<?php foreach ($videos as $video): ?>
                <div class="col-lg-4">
                    <div class="video">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><?= htmlspecialchars($video['title']); ?></h3>
                                <p class="card-text">Category: <?= htmlspecialchars($video['category']); ?></p>
                                <?php
                                $videoId = getYouTubeVideoId($video['link']);
                                if ($videoId !== false) 
                                {
                                    $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                    echo '<div class="embed-responsive embed-responsive-16by9">';
                                    echo '<iframe class="embed-responsive-item" src="' . $embedUrl . '" frameborder="0" allowfullscreen></iframe>';
                                    echo '</div>';
                                } else 
                                {
                                    echo '<p class="text-danger">Invalid YouTube link</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
<?php endforeach; ?>