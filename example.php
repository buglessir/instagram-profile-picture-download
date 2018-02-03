<?php error_reporting(E_ERROR); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Example</title>
</head>
<body>

<form method="post">
    <strong>Instagram Username :</strong>
    <input type="text" name="username" placeholder="example: instagram">
    <input type="submit" name="btn_sbmt" value="Go">
</form>

<?php

/*
    Code by : https://github.com/buglessir - Mohammad Esmaeilzadeh
*/

if ( $_POST['btn_sbmt'] && $_POST['username'] ) {

    $url = 'https://instagram.com/' . $_POST['username'];

    $html = file_get_contents($url);

    $dom = new DOMDocument();

    $dom->loadHTML($html);

    $meta_tags = $dom->getElementsByTagName('meta');

    foreach( $meta_tags as $meta ) {

        if( $meta->getAttribute('property') == 'og:image' ) {

            $image_url = $meta->getAttribute('content');

            if( $image_url ) {

                $replace = array(
                    '/vp' => '',
                    's150x150' => 's1080x1080'
                );

                $large_url = strtr($image_url, $replace);

                echo '
                    <a href="'. $large_url .'" target="_blank">
                        <img src="'. $large_url .'" alt="'. $_POST['username'] .'" width="500" height="auto">
                    </a>
                ';

            } else {

                echo '<strong>Image not found !</strong>';

            }

        }

    }

}

?>

</body>
</html>
