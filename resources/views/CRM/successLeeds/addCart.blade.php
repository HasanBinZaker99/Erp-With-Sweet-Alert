@extends('CRM.layouts_successLeeds.leedsNav')
@section('leedContent')
<div class="content-wrapper mx-auto">
    <section class="pb-5 pt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Add Cart</div>
                        <div class="card-body">
                            <h4 class="text-success">{{ Session::get('message') }}</h4>
                                <create-cart></create-cart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</div>

@endsection

<script>
    import CreateCart from "../../../js/components/CreateCart";
    export default {
        components: {CreateCart}
    }
</script>
