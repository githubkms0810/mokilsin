<!-- 약관 동의 시작 -->

					
						<!-- <div class="clearfix visible-sm visible-xs"></div> -->
                        
							<div class="form-group-item">
                            <div>
                            <label class="project_label" style="margin-left:-15px; !important; padding-left:0px !important;">목일신 이용약관 안내</label>
                            </div>
								<label class="control-label">  </label>
							</div>
							<div class="form-group-item">
                            <?php if ( $kind ==="동요" ): ?>
                                
                            
								<textarea class="form-control jy-font-regular" readonly="" rows="10" cols="100" >
  위와 같이 제6회 목일신 동요제 참가를 신청합니다.

  *수상자(상금수령자)는 본 회의 양식에 의거하여 수령증을 작성하여야 하며, 본인계좌로만 상금수령이 가능합니다.
</textarea>
<?php endif; ?>
<?php if ( $kind ==="동시" ): ?>
                                
                            
								<textarea class="form-control jy-font-regular" readonly="" rows="10" cols="100" >
  위와 같이 제7회 목일신 동시대회 참가를 신청합니다.

  *수상자(상금수령자)는 본 회의 양식에 의거하여 수령증을 작성하여야 하며, 본인계좌로만 상금수령이 가능합니다.
  -입선시 작품에 대한 일체 권리 (저자권, 저작재산권, 저작인견권, 소유권, 사용권 등)는 고흥군에 있으며 향후 고흥군에서 홍보용으로 활용하는데 동의합니다.
  -입선시 추후 모음집 발행 및 개사(필요시)를 통해 창작 동요곡으로 활용하거나 음반제작 등에 관련된 모든 사항에 이의를 제기하지 않기로 동의합니다.
</textarea>
<?php endif; ?>
							</div>
							<div class="form-group-item">
								<div class="checkbox pull-right">
									<label for="join_priv_agree">
                                        <input  class="project_form-list" type="checkbox" name="is_exist_budget" value="0"  id="project_budgetyet" required>
						                <label style="margin-top:4.1px !important; padding-top:4.1px !important;" for="project_budgetyet">위 내용을 숙지 하였습니다.</label>
										<!-- <input type="checkbox" name="join_priv_agree" id="join_priv_agree" value="1"> -->
                                    </label>
								</div>
							</div>

<!-- 약관 동의 끝 -->