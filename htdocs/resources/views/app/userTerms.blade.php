@extends('/app/layouts.app')

@section('content')
	<style>
		p{
			text-align: justify
		}
	</style>
<div class="container py-2 bg-light fixed-top">
	<div class="d-flex justify-content-between align-items-center text-mute">
		<a href=" javascript:history.back();"  class="top-nav-item"><i class="fa fa-angle-left"></i></a>
		<h6 class="top-nav-title">
                	<script type="text/javascript">
                	Language("用户条款","Terms of Use")
                </script></h6>
		<a href="##" class="top-nav-item"></a>
	</div>
</div>


<div class="container p-1 pt-5 mt-5">
	<div class="col-12">
		{!! $data !!}
	</div>
</div>
@endsection





@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('#mobile-nav').hide();
	});
</script>

@endsection