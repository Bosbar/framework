<?php 

namespace Bosbar;

/**
 * Master View class.
 * @category   Core
 * @package    SG
 */
class View
{
    
    private $data = array();
    private $render = false;

    /**
     * 
     */
    public function __construct() {
        $this->data['author'] = 'Bosbar Developers';
        $this->data['breadcrums'] = '';
        $this->data['postcontent'] = array(); // must be printed after content
        $this->data['content'] = '';
        $this->data['css'] = '';
        $this->data['precontent'] = array(); // must be printed before content
        $this->data['footer'] = '';
        $this->data['header'] = '';
        $this->data['js'] = ''; // loaded in header
        $this->data['js_footer'] = ''; // loaded in footer
        $this->data['meta_description'] = '';
        $this->data['meta_keywords'] = '';
        $this->data['navbar'] = '';
        $this->data['sidebar'] = '';
        $this->data['site_icon'] = '';
        $this->data['site_title'] = '';
    }

    /**
     * Assign value to global var.
     * @param string $key   Variable name.
     * @param mixed  $value Value to store.
     * @return void
     */
    public function assign($key = '', $value = null) {
        if ($key == '') {
            $this->data = $value;
        } else {
            if ($key == 'precontent' || $key == 'postcontent') {
                $this->data[$key] = array_merge($this->data[$key], $value);
            } else {
                $this->data[$key] = $value;
            }
        }
    }

    // /**
    //  * Assign a template to the view.
    //  * @param string $fileName  The filename of the target template.
    //  * @param array  $vars      The array with the expected variables (must be in the correct order!)
    //  * @param string $nameSpace The string of the namespace, leave empty if standard.
    //  * @return boolean
    //  */
    // public function assignTemplate($fileName, $vars = array(), $nameSpace = "") {
    //     return $this->data['templater']->assignTemplate($fileName, $vars, $nameSpace);
    // }

    /**
     * Render the view.
     * @param string  $view         View to render (file path).
     * @param boolean $directOutput Output directly or first buffer.
     * @return string  Rendered view or error message.
     */
    public function render($view, $directOutput = false) {
        if (substr($view, -4) == ".php") {
            $file = $view;
        } else {
            $file = ROOT . DS . 'views' . DS . strtolower($view) . '.php';
        }

        if (file_exists($file)) {

            /**
             * Trigger render to include file when this model is destroyed
             * if we render it now, we wouldn't be able to assign variables
             * to the view!
             */
            $this->render = $file;
        } else {
            return $file . " file doesn't exist.";
        }

        // Turn output buffering on, capturing all output.
        if ($directOutput !== true) {
            ob_start();
        }

        // Parse data variables into local variables.
        $data = $this->data;

        // Get template
        include($this->render);

        // Get the contents of the buffer and return it.
        if ($directOutput !== true) {
            return ob_get_clean();
        }
    }

    /**
     * Echo the view and everything that comes with it.
     * @return string Outputted text.
     */
    public function outPutView() {
        $arr = array('header','custom_header','carousel','navbar','sidebar','breadcrums','precontent','content','postcontent','footer');
        foreach ($arr as $torender) {
            if (is_array($this->data[$torender])) {
                sort($this->data[$torender]);
                foreach ($this->data[$torender] as $toOuput) {
                    echo $this->render($toOuput, true);
                }
            } else {
                echo $this->data[$torender];
            }
        }
    }

    /**
     * Set the title of the page.
     * @param string $name Title to set.
     * @return void
     */
    public function setSiteTitle($name) {
        $this->data['site_title'] = strval($name);
    }

    /**
     * Set the icon.
     * @param string $filename File of the icon.
     * @param string $website  Path of the site.
     * @return void
     */
    public function setSiteIcon($filename, $website = SITE_ROOT) {
        $this->data['site_icon'] = '<link href="' . $website . 'public/img/' . $filename . '" rel="shortcut icon" type="image/vnd.microsoft.icon" />';
    }

    /**
     * Set the author.
     * @param string $name Name of the author.
     * @return void
     */
    public function setAuthor($name) {
        $this->data['author'] = '' . $name . '';
    }

    /**
     * Set meta keywords.
     * @param string $words Meta info.
     * @return void
     */
    public function setMetaKeywords($words) {
        $this->data['meta_keywords'] = '<meta name="keywords" content="' . $words . '" />';
    }

    /**
     * Set meta description.
     * @param string $descr Meta info.
     * @return void
     */
    public function setMetaDescription($descr) {
        $this->data['meta_description'] = '<meta name="description" content="' . $descr . '" />';
    }

    /**
     * Add local css file to array.
     * @param string $filename Css file name without extension (in public/css).
     * @param string $website  Root path.
     * @return void
     */
    public function setCSS($filename, $website = SITE_ROOT) {
        $this->data['css'] = $this->data['css'] . '<link href="' . $website . 'public/css/' . str_replace('\\', '/', $filename) . '?v=' . CSS_VERSION . '" rel="stylesheet" type="text/css" />';
    }

    /**
     * Add external css to array.
     * @param string $filename Css file name without extension.
     * @param string $website  Root path.
     * @return void
     */
    public function setCSSExternal($filename, $website = SITE_ROOT) {
        $this->data['css'] = $this->data['css'] . '<link href="' . $website . str_replace('\\', '/', $filename) . '" rel="stylesheet" type="text/css" />';
    }

    /**
     * Add local js file to array.
     * @param string $filename JS file name without extension (in public/js).
     * @param string $website  Root path.
     * @return void
     */
    public function setJS($filename, $website = SITE_ROOT) {
        // if (MINIFIED && !\SG\Handlers\FileHandler::endsWith($filename, ".min.js")) {
            $filename = str_replace(".js", ".min.js", $filename);
        // }
        $this->data['js'] = $this->data['js'] . '<script type="text/javascript" src="' . $website . 'public/js/' . $filename . '?v=' . JS_VERSION . '"></script>' . PHP_EOL;
    }

    /**
     * Add external js to array.
     * @param string $filename JS file name without extension.
     * @param string $website  Root path.
     * @return void
     */
    public function setJSExternal($filename, $website = SITE_ROOT) {
        $this->data['js'] = $this->data['js_footer'] . '<script type="text/javascript" src="' . $website . $filename . '"></script>' . PHP_EOL;
    }

    /**
     * Add local js file to array for the footer.
     * @param string $filename JS file name without extension (in public/js).
     * @param string $website  Root path.
     * @return void
     */
    public function setJSFooter($filename, $website = SITE_ROOT) {
        // if (MINIFIED && !\SG\Handlers\FileHandler::endsWith($filename, ".min.js")) {
            $filename = str_replace(".js", ".min.js", $filename);
        // }
        $this->data['js_footer'] = $this->data['js_footer'] . '<script type="text/javascript" src="' . $website . 'public/js/' . $filename . '?v=' . JS_VERSION . '"></script>' . PHP_EOL;
    }

    /**
     * Add tiny mce reference.
     * @param string $filename JS file name without extension (in public/tinymce).
     * @param string $website  Root path.
     * @return void
     */
    public function setTINY($filename, $website = SITE_ROOT) {
        $this->data['js'] = $this->data['js'] . '<script type="text/javascript" src="' . $website . 'public/tinymce/' . $filename . '"></script>' . PHP_EOL;
    }

    /**
     * Add JS maps reference.
     * @param string $filename JS file name without extension.
     * @return void
     */
    public function setMapsJS($filename) {
        $this->data['js'] = $this->data['js'] . '<script type="text/javascript" src="' . $filename . '"></script>' . PHP_EOL;
    }

    /**
     * Set no index element.
     * @return void
     */
    public function setNoIndex() {
        $this->data['no_index'] = '<meta name="robots" content="noindex">';
    }

    /**
     * Get this data.
     * @return  array data.
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Check if $key is reserved.
     * @param  string $key The key to check.
     * @return boolean      True if reserved else false.
     */
    public function isReserved($key) {
        $arr = array('header','carousel','navbar','sidebar','breadcrums','precontent','content','postcontent','footer','site_title','site_icon','author','meta_description','meta_keywords','no_index');
        if (in_array($key, $arr)) {
            return true;
        }
        return false;
    }
}