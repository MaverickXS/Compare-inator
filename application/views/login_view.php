        <form method="post" action="/login/">
            <? if ($login_error!=''){ ?>
                 <div class="alert alert-error">
                    <h4 class="alert-heading">Login Failed!</h4>
                    <?=$login_error;?>
                 </div>
            <? } ?>
            <dl>
                <dt>E-mail:</dt>
                    <dd><input type="email" name="email" id="email" value="<?=set_value('email');?>" placeholder="johndoe@compare-inator.com" required="required" onkeyup="fncLoginReady();" /><?=form_error('email');?></dd>
                <dt>Password:</dt>
                    <dd><input type="password" name="pw" id="pw" value="<?=set_value('pw');?>" required="required" onkeyup="fncLoginReady();" /><?=form_error('pw');?></dd>
                <dt><button type="submit" id="login_submit_btn" class="btn" disabled="disabled">Login</button></dt>
            </dl>
        </form>
        <script type="text/javascript">
            fncLoginReady();
        </script>