<?php
/**
 * Created by PhpStorm.
 * User: dominik
 * Date: 05/05/14
 * Time: 14:30
 */

class opw_menu {
    protected $opw = false;

    public function __construct($opw = false){
        if($opw){
            $this->opw = $opw;
        } else {
            $this->opw = new opw();
        }
    }

    public function changeSettings($post){
        check_admin_referer( 'opw' );
        $styles = (isset($_POST['styles'])) ? trim($_POST['styles']) : "";
        $text = (isset($_POST['text'])) ? trim($_POST['text']) : "";
        $oldoptions = $this->opw->getOptions();
        $options = new stdClass();
        if(trim($styles) != "") {
            $options->styles = $styles;
        } else {
            $options->styles = $oldoptions->styles;
        }
        if(trim($text) != "") {
            $options->text = $text;
        } else {
            $options->text = $oldoptions->text;
        }
        $this->opw->setOptions($options);
    }

    public function render(){
        $options = $this->opw->getOptions();
        ?>
<div class="wrap">
    <h2>Old Post Warning</h2>
    <form method="post">
        <table class='form-table'>
            <tr>
                <th scope='row'><?php _e("Text","opw"); ?>:</th>
                <td>
                    <textarea name="text" rows="10" cols="50" id="opw_text" class="large-text code"><?php echo esc_textarea($options->text); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope='row'><?php _e("Styles","opw"); ?>:</th>
                <td>
                    <textarea name="styles" rows="10" cols="50" id="opw_styles" class="large-text code"><?php echo esc_textarea($options->styles); ?></textarea>
                </td>
            </tr>
        </table>
        <?php wp_nonce_field( 'opw' ); ?>
        <?php submit_button('Update'); ?>
    </form>
</div>
<?php
    }
} 