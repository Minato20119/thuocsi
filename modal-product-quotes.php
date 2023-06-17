<div id="confirmListBaoGia" class="modal">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header" style="background-color: deepskyblue;">
                <h5 class="modal-title">DANH SÁCH BÁO GIÁ SẢN PHẨM ĐÃ CHỌN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="overflow-scroll">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%;">Hình ảnh</th>
                                <th style="text-align: left;">Tên sản phẩm</th>
                                <th style="width: 14%;">SL tối đa đáp ứng<br>/<br>SL yêu cầu</th>
                                <th style="width: 16%;">Giá đáp ứng<br>/<br>Giá đề nghị<br>
                                    <p style="font-size: xx-small;">(Giá đã bao gồm VAT)</p>
                                </th>
                                <th style="width: 15%;">Kho hàng đến</th>
                                <th style="width: 5%;">Remove</th>
                            </tr>
                        </thead>
                        <tbody id="resultModal">

                          <!-- result-modal-product-quotes -->

                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeModal">Close</button>
                    <button type="button" class="btn btn-success" id="submitDuyet">Hoàn Tất Báo Giá</button>
                </div>
            </div>
        </div>
    </div>
</div>