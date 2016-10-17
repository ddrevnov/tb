<div id="tab-6" class="tab-content is-active">
    <table class="table table--striped" id="category-table">
        <thead>    
            <tr>
                <th>Nr:</th>
                <th>Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="sortable">
            <?php $i = 1; ?>
            @foreach ($categoryList as $category)
            <tr data-category-id="{{$category->id}}" class="category">
                <td class="category_number">{{$i}}</td>
                <td class="category_name">{{$category->category_name}}</td>
                <td class="category_status">{{{$category->category_status ? 'Activ' : 'Not Activ'}}}</td>
                <td>
                    <a href="#" class="delete-category">
                        <i class="i">
                            {!! file_get_contents(asset('images/svg/rubbish-bin.svg')) !!}
                        </i>
                    </a>
                </td>
            </tr>
            <?php $i++ ?>
            @endforeach
        </tbody>
    </table>
    <div class="admin-edit-button" id="open-category-remodal">
        <a href="#" class="btn btn--red">Create new Category</a>
    </div>
</div>