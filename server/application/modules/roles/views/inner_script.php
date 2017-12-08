<script>

    jQuery('body').on('click', '#submit', function () {

        var form_name = this.form.id;
        if (form_name == '[object HTMLInputElement]')
            form_name = 'editFormAjax';
        $("#" + form_name).validate({
            rules: {
                user_name: "required",
                user_email: {
                    required: true,
                    email: true
                },
                phone_number: {
                    required: true,
                    minlength: 10,
                    maxlength: 20,
                    number: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password",
                    minlength: 6
                },
                new_password: {
                    minlength: 6
                },
                confirm_password1: {
                    equalTo: "#new_password",
                    minlength: 6
                },
                date_of_birth: "required",
            },
            messages: {
                user_name: '<?php echo lang('user_name_validation'); ?>',
                user_email: {
                    required: '<?php echo lang('user_email_validation'); ?>',
                    email: '<?php echo lang('user_email_field_validation'); ?>'
                },
                phone_number: {
                    required: '<?php echo lang('phone_number_validation'); ?>',
                },
                password: {
                    required: '<?php echo lang('password_required_validation'); ?>',
                    minlength: '<?php echo lang('password_minlength_validation'); ?>',
                },
                confirm_password: {
                    required: '<?php echo lang('confirm_password_required_validation'); ?>',
                    equalTo: '<?php echo lang('confirm_password_equalto_validation'); ?>',
                    minlength: '<?php echo lang('confirm_password_minlength_validation'); ?>',
                },
                new_password: {
                    minlength: '<?php echo lang('password_minlength_validation'); ?>',
                },
                confirm_password1: {
                    equalTo: '<?php echo lang('confirm_password_equalto_validation'); ?>',
                    minlength: '<?php echo lang('confirm_password_minlength_validation'); ?>',
                },
                date_of_birth: '<?php echo lang('date_of_birth_validation'); ?>'

            },
            submitHandler: function (form) {
                jQuery(form).ajaxSubmit({
                });
            }
        });
    });
    

    $('#common_datatable_roles').dataTable({
        order: [],
        columnDefs: [{orderable: false, targets: [2,3]}]
    });

</script>


