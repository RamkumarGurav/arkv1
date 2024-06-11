<?php $page_module_name = "City"; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= $page_module_name ?> <small>List</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= MAINSITE_Admin . "wam" ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= $page_module_name ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <? ?>
    <section class="content">
        <div class="row">
            <div class="col-12">


                <!--   {{{{{{{{{{ Search Accordian-->
                <div id="accordion" class="bg-secondary">
                    <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class=""
                                    aria-expanded="false">
                                    Search Panel
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" style="">
                            <div class="card-body">
                                <!--   {{{{{{{{{{ Search Form -->
                                <?php echo form_open(MAINSITE_Admin . "$user_access->class_name/$user_access->function_name", array('method' => 'post', 'id' => 'search_report_form', "name" => "search_report_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Field</label>
                                                <select name="field_name" id="field_name" class="form-control"
                                                    style="width: 100%;">
                                                    <!-- <option value=''>Select Field</option> -->
                                                    <option value='urm.city_name' <? if ($field_name == 'urm.city_name') {
                                                        echo 'selected';
                                                    } ?>>City
                                                    </option>
                                                    <option value='urm.city_code' <? if ($field_name == 'urm.city_code') {
                                                        echo 'selected';
                                                    } ?>>City Code
                                                    </option>
                                                </select>

                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Field Value</label>
                                                <input type="text" name="field_value" id="field_value"
                                                    placeholder="Field Value" style="width: 100%;" class="form-control"
                                                    value="<?= $field_value ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <select type="text" class="form-control" id="country_id"
                                                    name="country_id" onchange="getState(this.value ,0)"
                                                    style="width: 100%;">
                                                    <option value="">Select Country</option>
                                                    <? foreach ($country_data as $cd) {
                                                        $selected = "";
                                                        if ($cd->country_id == $country_id) {
                                                            $selected = "selected";
                                                        }
                                                        ?>
                                                        <option value="<?= $cd->country_id ?>" <?= $selected ?>>
                                                            <?= $cd->country_name ?>
                                                            <? if ($cd->status != 1) {
                                                                echo " [Block]";
                                                            } ?>
                                                        </option>
                                                    <? } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>State</label>
                                                <select type="text" class="form-control" id="state_id" name="state_id"
                                                    style="width: 100%;">
                                                    <option value="">Select State</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <div class="input-group date reservationdate" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" value="<?= $start_date ?>" name="start_date"
                                                        id="start_date" placeholder="Start Date" style="width: 100%;"
                                                        class="form-control datetimepicker-input"
                                                        data-target="#reservationdate" />
                                                    <div class="input-group-append" data-target="#reservationdate"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <div class="input-group date reservationdate1" id="reservationdate1"
                                                    data-target-input="nearest">
                                                    <input type="text" value="<?= $end_date ?>" name="end_date"
                                                        id="end_date" placeholder="End Date" style="width: 100%;"
                                                        class="form-control datetimepicker-input"
                                                        data-target="#reservationdate1" />
                                                    <div class="input-group-append" data-target="#reservationdate1"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="record_status" id="record_status" class="form-control"
                                                    style="width: 100%;">
                                                    <option value=''>Active / Block</option>
                                                    <option value='1' <? if ($record_status == 1) {
                                                        echo 'selected';
                                                    } ?>>
                                                        Active</option>
                                                    <option value='zero' <? if ($record_status == 'zero') {
                                                        echo 'selected';
                                                    } ?>>Block</option>
                                                </select>

                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-6">

                                        </div>
                                    </div>


                                </div>
                                <div class="panel-footer">
                                    <center>
                                        <button type="submit" class="btn btn-info" id="search_report_btn"
                                            name="search_report_btn" value="1">Search</button>
                                        &nbsp;&nbsp;<button type="reset" class="btn btn-default">Reset</button>
                                    </center>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                            <!-- }}}}}}}}}}}} Search Form  -->
                        </div>
                    </div>

                </div>

                <!-- }}}}}}}}}}}} Search Accordian  -->



                <!--   {{{{{{{{{{ Main Card with actions and Table -->
                <div class="card">
                    <!--   {{{{{{{{{{ Main Card Header -->
                    <div class="card-header">
                        <h3 class="card-title"><span style="color:#FF0000;">Total Records:
                                <?php echo $row_count; ?></span></h3>
                        <div class="float-right">
                            <?php
                            if ($user_access->add_module == 1) {
                                ?>
                                <a href="<?= MAINSITE_Admin . $user_access->class_name ?>/city-edit">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                                        New</button></a>
                            <? } ?>
                            <?php
                            if ($user_access->update_module == 1) {
                                ?>
                                <button type="button" class="btn btn-success btn-sm" onclick="validateRecordsActivate()"><i
                                        class="fas fa-check"></i> Active</button>
                                <button type="button" class="btn btn-dark btn-sm" onclick="validateRecordsBlock()"><i
                                        class="fas fa-ban"></i> Block</button>
                            <? } ?>
                            <?php
                            if ($user_access->export_data == 1) {
                                ?>
                                <button type="button" class="btn btn-success btn-sm export_excel"><i
                                        class="fas fa-file-excel"></i> Export</button>
                            <? } ?>
                        </div>
                    </div>
                    <!-- }}}}}}}}}}}} Main Card Header  -->

                    <!--   {{{{{{{{{{ Main Table-->
                    <?php
                    if ($user_access->view_module == 1) {
                        ?>
                        <div class="card-body">

                            <?php echo form_open(
                                MAINSITE_Admin . "$user_access->class_name/userCity-doUpdateStatus",
                                array(
                                    'method' => 'post',
                                    'id' => 'ptype_list_form',
                                    "name" => "ptype_list_form",
                                    'style' => '',
                                    'class' => 'form-horizontal',
                                    'role' => 'form',
                                    'enctype' => 'multipart/form-data'
                                )
                            ); ?>

                            <input type="hidden" name="task" id="task" value="" />
                            <? echo $this->session->flashdata('alert_message'); ?>
                            <table id="example1" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <?php if ($user_access->update_module == 1) { ?>
                                            <th width="4%"><input type="checkbox" name="main_check" id="main_check"
                                                    onclick="check_uncheck_All_records()" value="" /></th>
                                        <? } ?>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>City Code</th>
                                        <th>Display</th>
                                        <th>Added On</th>
                                        <th>Added By</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <? if (!empty($city_data)) { ?>
                                    <tbody>
                                        <?
                                        $offset_val = (int) $this->uri->segment(5);

                                        $count = $offset_val;

                                        foreach ($city_data as $urm) {
                                            $count++;
                                            ?>
                                            <tr>
                                                <td><?= $count ?>.</td>
                                                <?php if ($user_access->update_module == 1) { ?>
                                                    <td><input type="checkbox" name="sel_recds[]" id="sel_recds<?php echo $count; ?>"
                                                            value="<?php echo $urm->city_id; ?>" /></td>
                                                <? } ?>
                                                <td><a
                                                        href="<?= MAINSITE_Admin . $user_access->class_name . "/city-view/" . $urm->city_id ?>"><?= $urm->city_name ?></a>
                                                </td>
                                                <td><?= $urm->state_name ?></td>
                                                <td><?= $urm->country_name ?></td>
                                                <td><?= $urm->city_code ?></td>
                                                <td>
                                                    <? if ($urm->is_display == 1) { ?> <i
                                                            class="fas fa-check btn-success btn-sm "></i>
                                                    <? } else { ?><i class="fas fa-ban btn-danger btn-sm "></i>
                                                    <? } ?>
                                                </td>
                                                <td><?= date("d-m-Y", strtotime($urm->added_on)) ?></td>
                                                <td><?= $urm->added_by_name ?></td>
                                                <td>
                                                    <? if ($urm->status == 1) { ?> <i class="fas fa-check btn-success btn-sm "></i>
                                                    <? } else { ?><i class="fas fa-ban btn-danger btn-sm "></i>
                                                    <? } ?>
                                                </td>
                                            </tr>
                                        <? } ?>
                                    </tbody>
                                <? } ?>
                            </table>
                            <?php echo form_close() ?>
                            <center>
                                <div class="pagination_custum"><? echo $this->pagination->create_links(); ?></div>
                            </center>
                        </div>
                    <? } else {
                        $this->data['no_access_flash_message'] = "You Dont Have Access To View " . $page_module_name;
                        $this->load->view('admin/template/access_denied', $this->data);
                    } ?>
                    <!--   }}}}}}}}}}}} Main Table-->
                </div>
                <!-- }}}}}}}}}}}}  Main Card with actions and Table  -->


            </div>
        </div>
    </section>
</div>



<? ?>
</div>

<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>

<script type="application/javascript">
    function check_uncheck_All_records() // done
    {
        var mainCheckBoxObj = document.getElementById("main_check");
        var checkBoxObj = document.getElementsByName("sel_recds[]");

        for (var i = 0; i < checkBoxObj.length; i++) {
            if (mainCheckBoxObj.checked)
                checkBoxObj[i].checked = true;
            else
                checkBoxObj[i].checked = false;
        }
    }

    // If the current checkbox is checked, the count variable is set to false. This indicates that at least one checkbox is checked.
    function validateCheckedRecordsArray() // done
    {
        var checkBoxObj = document.getElementsByName("sel_recds[]");
        var count = true;

        for (var i = 0; i < checkBoxObj.length; i++) {
            if (checkBoxObj[i].checked) {
                //if any one of the checkbox is checked then count will be false and we stop the loop
                count = false;
                break;
            }
        }

        return count;
    }

    function validateRecordsActivate() // done
    {
        // Check if no checkboxes are checked
        if (validateCheckedRecordsArray()) {
            // If no checkboxes are checked, display an error message
            toastrDefaultErrorFunc("Please select any record to activate.");
            // Set focus to the first checkbox element with the name "sel_recds[]"
            document.getElementById("sel_recds1").focus();
            return false;
        } else {
            // If checkboxes are checked, set the task value and submit the form
            document.ptype_list_form.task.value = 'active';
            document.ptype_list_form.submit();
        }
    }

    function validateRecordsBlock() // done
    {
        // Check if no checkboxes are checked
        if (validateCheckedRecordsArray()) {
            // If no checkboxes are checked, display an error message
            toastrDefaultErrorFunc("Please select any record to block.");
            // Set focus to the first checkbox element with the name "sel_recds[]"
            document.getElementById("sel_recds1").focus();
            return false;
        } else {
            // If checkboxes are checked, set the task value and submit the form
            document.ptype_list_form.task.value = 'block';
            document.ptype_list_form.submit();
        }
    }
</script>

<script>

    function getState(country_id, state_id = 0) {
        $('#loader1').show();
        $("#state_id").html('');
        if (country_id > 0) {
            Pace.restart();
            $.ajax({
                url: "<?= MAINSITE_Admin . 'Ajax/getState' ?>",
                type: 'post',
                dataType: "json",
                data: { 'country_id': country_id, 'state_id': state_id, "<?= $csrf['name'] ?>":"<?= $csrf['hash'] ?>" },
                success: function (response) {
                    $("#state_id").html(response.state_html);
                },
                error: function (request, error) {
                    toastrDefaultErrorFunc("Unknown Error. Please Try Again");
                    $("#quick_view_model").html('Unknown Error. Please Try Again');
                }
            });
        }

    }

    window.addEventListener('load', function () {

        $(".paginationClass").click(function () {
            // console.log($(this).data('ci-pagination-page'));
            // console.log($(this));
            // console.log($(this).attr('href'));//alert();
            //alert(this.data('ci-pagination-page'));
            $('#search_report_form').attr('action', $(this).attr('href'));
            $('#search_report_form').submit();
            return false;
        });

        //initilazing date pickers
        $('#reservationdate').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#reservationdate1').datetimepicker({
            format: 'DD-MM-YYYY'
        });


        // Event listener for click events on elements with the class "export_excel".
        $(".export_excel").bind("click", function () {
            // This function is executed when an element with class "export_excel" is clicked.

            // Set the form action attribute to export URL.
            $('#search_report_form').attr('action',
                '<? echo MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name . "-export"; ?>');
            // Set the form target to '_blank' to open in a new tab.

            $('#search_report_form').attr('target',
                '_blank');

            // Trigger click event on the search report button.
            $('#search_report_btn').click();

            // Reset the form action attribute and target.
            $('#search_report_form').attr('action', '<? echo MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name; ?>');
            $('#search_report_form').attr('target', '');
        });

        <? if (!empty($country_id) && !empty($state_id)) { ?>
            // If country_id and state_id are not empty, call getState function with these values.
            getState(<?= $country_id ?> , <?= $state_id ?>)
        <? } ?>

    })

</script>