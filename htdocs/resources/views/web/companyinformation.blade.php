@extends('web/layout.app')

@section('content')
<style type="text/css">
	.categoryBg .maxCentr{
		padding: 8% 0 10% 0;
	}
	p{
		margin: 0;
		color: #202020;
	}
	h3{
		text-align: center;
	}
</style>

    <!--中间体-->
    <div class="categoryBg">
        <div class=" maxCentr clearfloat">
        		<h3>
					<script>
					Language(`{{ $res['zn_name'] }}`,`{{ $res['en_name'] }}`)
					</script>
				</h3>
        		<div style="width: 80%; margin: 0 auto;">
	            <script>
	            Language(`{!! $res['zn_content'] !!}`,`{!! $res['en_content'] !!}`)
	            {{--{!! $res->zn_name !!}--}}
	            </script>
        		</div>
            </div>
    </div>

@endsection
