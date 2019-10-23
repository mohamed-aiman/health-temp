@extends('layouts.app')

@section('content')

@verbatim
<div v-can="'api.user.activities'">
@endverbatim

@include('components.heading', ['title' => '‫User Activities'])
@verbatim
<div>
    <table class="table is-narrow">
        <thead>
            <td>Description</td>
            <td>Subject id</td>
            <td>Subject type</td>
            <td>Logged At</td>
        </thead>
        <tbody>
            <tr v-for="item,key in activities">
                <td>{{item.description}}</td>
                <td>{{item.subject_id}}</td>
                <td>{{item.subject_type}}</td>
                <td>{{item.created_at}}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="container">
    <b-pagination
        :total="pagination.total"
        :current.sync="pagination.current"
        :order="pagination.order"
        :size="pagination.size"
        :simple="pagination.isSimple"
        :rounded="pagination.isRounded"
        :per-page="pagination.perPage"
        @change="pageChange">
    </b-pagination>
</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/activities-index.js')}}"></script>
@endsection