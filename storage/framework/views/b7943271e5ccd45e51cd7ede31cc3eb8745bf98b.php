<?php
if (!function_exists('renderDataAttributes')) {
    function renderDataAttributes($attributes)
    {
        $mapped = [ ];
        foreach ($attributes as $key => $value) {
            $mapped[] = 'data-' . $key . '="' . $value . '"';
        };
 
        return implode(' ', $mapped);
    }
}
?>
<div class="form-group<?php echo e($errors->has('g-recaptcha-response') ? ' has-error' : ''); ?>" style="margin-top: 1.4rem;" align="center">
    <div class="col-md-12">
        <?php if(!empty($options)): ?>
            <script type="text/javascript">
                var RecaptchaOptions = <?=json_encode($options) ?>;
            </script>
        <?php endif; ?>
        <script src='https://www.google.com/recaptcha/api.js?render=onload<?php echo e((isset($lang) ? '&hl='.$lang : '')); ?>'></script>
        <div class="g-recaptcha" data-sitekey="<?php echo e($public_key); ?>" <?=renderDataAttributes($dataParams)?>></div>
        <noscript>
            <div style="width: 302px; height: 352px;">
                <div style="width: 302px; height: 352px; position: relative;">
                    <div style="width: 302px; height: 352px; position: absolute;">
                        <iframe src="https://www.google.com/recaptcha/api/fallback?k=<?php echo e($public_key); ?>"
                                frameborder="0" scrolling="no"
                                style="width: 302px; height:352px; border-style: none;">
                        </iframe>
                    </div>
                    <div style="width: 250px; height: 80px; position: absolute; border-style: none;
                          bottom: 21px; left: 25px; margin: 0; padding: 0; right: 25px;">
                <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                          class="g-recaptcha-response"
                          style="width: 250px; height: 80px; border: 1px solid #c1c1c1;
                                 margin: 0; padding: 0; resize: none;"></textarea>
                    </div>
                </div>
            </div>
        </noscript>
        <?php if($errors->has('g-recaptcha-response')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
            </span>
        <?php endif; ?>
    </div>
</div>