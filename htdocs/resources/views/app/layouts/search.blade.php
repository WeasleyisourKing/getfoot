<form  action="/apps/productList" method="get">
    <div class="input-group">
        <div class="input-group-prepend">
                       <span class="input-group-btn top-search-prepend shaddow-light  input-group-text ">
						<button class="btn btn-default input-group-btn top-search-prepend   input-group-text"onsubmit="$('#Search').submit();"style="background: none">
							<i class="fa fa-search"></i>
						</button>
					</span>

        </div>

        <input name="search"   type="text" class="form-control top-search-input shaddow-light" aria-label="Search"
               aria-describedby="">
            {{--<button type="submit" name="btn" value="btn" />--}}
        </form>
    </div>

