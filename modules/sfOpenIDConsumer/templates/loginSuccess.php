<?php use_helper('I18N') ?>

<?php if($sf_user->hasFlash('sf_openid.success')): ?>
  <?php echo __($sf_user->getFlash('sf_openid.success')) ?>
<?php endif; ?>

<?php if($sf_user->hasFlash('sf_openid.error')): ?>
  <?php echo __($sf_user->getFlash('sf_openid.error')) ?>
<?php endif; ?>

<form action="<?php url_for('sf_openid_consumer_login') ?>" method="post">
  <table>
    <?php echo $form ?>
    <tr>
      <td colspan="2">
        <input type="submit" value="Login"/>
      </td>
    </tr>
  </table>
</form>