/*------------------足球--------------------*/
$("img.competition-photo").imagesLoaded()
    .progress( function( instance, image ) {
        if(!image.isLoaded){
            image.img.src=IMG_PATH+'default-match.png';
        }
});

$("img.team-photo").imagesLoaded()
    .progress( function( instance, image ) {
        if(!image.isLoaded){
            image.img.src=IMG_PATH+'default-team.png';
        }
});

$("img.player-photo").imagesLoaded()
    .progress( function( instance, image ) {
        if(!image.isLoaded){
            image.img.src=IMG_PATH+'default-player.png';
        }
});

/*----------------------篮球----------------------*/
$("img.bt-competition-photo").imagesLoaded()
    .progress( function( instance, image ) {
        if(!image.isLoaded){
            image.img.src=IMG_PATH+'bt_default_match.png';
        }
    });

$("img.bt-team-photo").imagesLoaded()
    .progress( function( instance, image ) {
        if(!image.isLoaded){
            image.img.src=IMG_PATH+'bt_default_team.png';
        }
    });

$("img.bt-player-photo").imagesLoaded()
    .progress( function( instance, image ) {
        if(!image.isLoaded){
            image.img.src=IMG_PATH+'bt_default_player.png';
        }
    });