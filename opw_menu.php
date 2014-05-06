<?php
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
        $styles = (isset($_POST['styles'])) ? trim($_POST['styles']) : false;
        $text = (isset($_POST['text'])) ? trim($_POST['text']) : false;
        $years = (isset($_POST['years'])) ? trim($_POST['years']) : false;
        $type = (isset($_POST['type'])) ? trim($_POST['type']) : opw::YEARS;
        $date = (isset($_POST['date'])) ? trim($_POST['date']) : false;

        $oldoptions = $this->opw->getOptions();
        $options = new stdClass();
        $options->styles = $styles;
        $options->text = $text;
        $options->years = $years;
        $options->type = $type;
        $options->date = $date;
        $options = (object) array_merge((array) $oldoptions, (array) $options);
        $this->opw->setOptions($options);
    }

    public function render(){
        $options = $this->opw->getOptions();
        ?>
<div class="wrap">
    <style>
        span.opw_radio {
            display:inline-block;
            width: 10%;
        }
    </style>
    <h2>Old Post Warning</h2>
    <form method="post">
        <table class='form-table'>
            <tr>
                <th scope='row' rowspan="2"><?php _e("Check","opw"); ?>:</th>
                <td>
                    <span class="opw_radio"><input type="radio" name="type" value="<?php echo opw::YEARS; ?>"<?php if($options->type == opw::YEARS) { ?> checked="checked"<?php } ?>> <?php _e("Age (in years)","opw"); ?>:</span>
                    <select name="years">
                        <option value="1"<?php if((int)$options->years == 1) echo "selected"; ?>>1</option>
                        <option value="2"<?php if((int)$options->years == 2) echo "selected"; ?>>2</option>
                        <option value="3"<?php if((int)$options->years == 3) echo "selected"; ?>>3</option>
                        <option value="1"<?php if((int)$options->years == 4) echo "selected"; ?>>4</option>
                        <option value="2"<?php if((int)$options->years == 5) echo "selected"; ?>>5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="opw_radio"><input type="radio" name="type" value="<?php echo opw::DATE; ?>"<?php if($options->type == opw::DATE) { ?> checked="checked"<?php } ?>> <?php _e("Date","opw"); ?>:</span>
                    <input name="date" type="date" value="<?php echo $options->date; ?>">
                </td>
            </tr>
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