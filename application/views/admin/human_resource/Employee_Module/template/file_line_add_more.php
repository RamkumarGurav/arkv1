
<?  $id=1; if(!empty($append_id)){ $id=$append_id; } ?>
    <tr class="qe_sub_table_tr">
      <td class="qe_sub_table_count">1</td>
      <td>
      <input type="text" name="file_title[]" id="file_title_<?=$id?>" placeholder="File Title" class="form-control search-code form-control-sm"  />
      <input type="hidden" name="quotation_enquiry_detail_id[]" id="quotation_enquiry_detail_id<?=$id?>" value="" />
      </td>
      <td><div class="input-group" >
        <div class="custom-file" >
            <input type="hidden" name="file_name[]" value="" />
            <input type="file" name="file[]"  class="custom-file-input"  >
            <label class="custom-file-label form-control-sm" for="files"></label>
        </div>
            </div>
      </td>
      <td class="qe_sub_table_remove_td"></td>
    </tr>

