<?php

if (!function_exists('get_page')) {

    function get_page($uri, $segments)
    {
        if (!isset($segments[2])) {

            switch ($uri) {

                case '/':
                    ob_start();
                    include __REALPATH__ . '/includes/home.php';
                    $content = ob_get_clean();
                    break;

                case '/a-propos':
                    ob_start();
                    include __REALPATH__ . '/includes/about.php';
                    $content = ob_get_clean();
                    break;

                case '/blog':
                    ob_start();
                    include __REALPATH__ . '/includes/blog.php';
                    $content = ob_get_clean();
                    break;

                case '/contact':
                    ob_start();
                    include __REALPATH__ . '/includes/contact.php';
                    $content = ob_get_clean();
                    break;

                case '/rgpd':
                    ob_start();
                    include __REALPATH__ . '/includes/rgpd.php';
                    $content = ob_get_clean();
                    break;

                case '/mention-legales':
                    ob_start();
                    include __REALPATH__ . '/includes/mentions-legales.php';
                    $content = ob_get_clean();
                    break;

                case 'cgu':
                    ob_start();
                    include __REALPATH__ . '/includes/cgu.php';
                    $content = ob_get_clean();
                    break;

                default:
                    ob_start();
                    include __REALPATH__ . '/includes/404.php';
                    $content = ob_get_clean();
                    http_response_code(404);
                    break;
            }

        } else {

            if (blog_dispatcher($segments) == false) {

                ob_start();
                include __REALPATH__ . '/includes/404.php';
                $content = ob_get_clean();
                http_response_code(404);

            } else {

                return blog_dispatcher($segments);
            }
        }

        return $content;
    }
}

if (!function_exists('blog_dispatcher')) {
    
    function blog_dispatcher($segments)
    {
        $name = str_replace('-', ' ', $segments[2]);
        $title = ucfirst($name);
        ob_start();
        include __REALPATH__ . '/includes/common/article.php';
        return ob_get_clean();
    }
}

if (!function_exists('maintenance')) {

    function maintenance()
    {
        $ip = [
            /*'90.50.145.182', // Fred
            '109.214.144.207', // Tristan
            '86.213.50.181' // Clément*/
        ];

        if ((isset($_SERVER['HTTP_X_FORWARDED_FOR']) && in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $ip))
            || (isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $ip))) {

            return true;

        } else {

            define('MAINTENANCE', true);
            require __REALPATH__ . '/includes/common/head.php';
            require __REALPATH__ . '/includes/maintenance.php';
            require __REALPATH__ . '/includes/common/footer.php';
            exit();
        }
    }
}
