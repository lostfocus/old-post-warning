<?php
class opw {
    protected $options = false;

    public function init(){
        add_filter('the_content', array($this, 'the_content'), 900);
        add_action('wp_head', array($this, 'insert_styles'),900);
        add_action( 'admin_menu', array($this, 'add_menu'),900);
    }

    public function the_content($content){
        global $post;

        if($post && $this->_is_old($post) && is_single()){
            $this->getOptions();
            $warningtext = nl2br($this->options->text);
            $warning = "<p class='opw-warning'>". $warningtext."</p>";
            $content = $warning ."\n\n". $content;
        }

        return $content;
    }

    public function add_menu(){
        add_management_page(
            'Old Post Warning',
            'Old Post Warning',
            'manage_options',
            'old_post_warning',
            array($this,'opw_menu')
        );
    }

    function opw_menu(){
        require_once(OPW_DIR.'/opw_menu.php');
        $opw_menu = new opw_menu($this);
        if(isset($_POST['submit'])){
            $opw_menu->changeSettings($_POST);
        }
        $opw_menu->render();
    }

    public function getOptions(){
        if($this->options){
            return $this->options;
        }
        $options = get_option("old_post_warning");
        if(!$options){
            $options = $this->_getDefaultOptions();
        }
        $this->options = $options;
        return $options;
    }

    public function setOptions($options){
        update_option('old_post_warning',$options);
        $this->options = $options;
    }

    protected function _getDefaultOptions(){
        $options = new stdClass();
        $options->styles = "border: 2px solid #fa8072;
border-radius: 3px;
background-color: #fff5ee;
padding:.5em;
";
        $options->text = __("This post is old!",'opw');
        $options->years = 1;
        return $options;
    }

    public function insert_styles(){
        $this->getOptions();
        $styles = $this->options->styles;

        ?>
        <style type="text/css">
            p.opw-warning {
<?php echo $styles; ?>
            }
        </style>
    <?php
    }

    protected function _is_old($post){
        $this->getOptions();
        $lastmodified = strtotime($post->post_modified_gmt);
        if($lastmodified < (time() - ($this->options->years * YEAR_IN_SECONDS))){
            return true;
        }
        return false;
    }
}