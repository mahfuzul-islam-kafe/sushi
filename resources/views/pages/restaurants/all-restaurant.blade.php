<x-layout>

    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
            <div class="d-flex justify-content-between mt-1 mb-3">
                <div style="float"class="mt-2">
                    <a href="#" class="btn btn-primary"><i class="fa fa-plus"></i> Add new
                        restaurant</a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($restaurants as $key => $restaurant)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $restaurant->name }}</td>
                            <td>{{ $restaurant->slug }}</td>
                            <td class="">

                                <a class="btn btn-sm btn-primary me-2" href="#"><i class="fa fa-edit"></i></a>
                                {{-- <a class="btn btn-sm btn-primary me-2" href="#"><i
                                    class="fa fa-eye"></i></a> --}}
                                {{-- <x-actions.delete :action="route('customers.destroy', $restaurant)" /> --}}
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

    </div>
</x-layout>
