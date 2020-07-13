<?php $this->load->view("partial/v_header"); ?>
<div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
            <form id="form_notifikasi" method="post">
                <div class="form-group">
                    <label>User</label>
                    <select class="form-control " name="to" id="to">
                        <option value="">-- Pilih User --</option>
                        <?php 
                            foreach ($users as $user) {
                                echo "<option value='".$user->email."'>".$user->first_name." ".$user->last_name."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" class="form-control" name="title" placeholder="Judul Notif">
                </div>
                <div class="form-group">
                    <label>Pesan</label>
                    <textarea class="form-control" rows="3" name="messages" placeholder="Tulis Pesan..."></textarea>
                </div>

             </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-primary btn-sm" type="button" id="btnKirim">Kirim</button>
        </div>
        <!-- /.box-footer-->
      </div>
<script>
    $(function(){
        $('#btnKirim').click(function(){
            $.ajax({
                url: "<?php echo site_url('notifikasi/kirim')?>",
                method: 'post',
                data: $('#form_notifikasi').serializeArray()
            }).done(function(result){
                console.log(result);
                alert('Terkirim');
                $('#form_notifikasi')[0].reset();
            })
        });
    });
</script>
<?php $this->load->view("partial/v_footer"); ?>