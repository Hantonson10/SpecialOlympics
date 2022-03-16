<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 11">
  <div id="liveToast" class="toast fade show text-white <?php if($datos == 'error' || $datos == 'Las contraseñas NO coinciden o estan vacias')echo "bg-danger"; else echo "bg-success";?>" 
  role="alert" aria-live="assertive" aria-atomic="true" shown-bs-toast="autohide">
    <div class="toast-header">
      <strong class="me-auto">Notificación</strong>
      <small><?php echo date('d-m-Y H:i:s'); ?></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?php echo $datos; ?>
    </div>
  </div>
</div>