@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style type="text/css">
    .form-check-label {
        text-transform: capitalize;
    }
</style>
    <div class="page-content">
        <div class="row profile-body">
            <div class="col-md-12 col-xl-12 middle-wapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                Add Roles Permission
                            </h6>
                            <form action="{{ route('store.roles.permission') }}" method="POST" class="forms-sample" id="myForm">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="role-id" class="form-label">Roles Name</label>
                                    <select name="role_id" id="role_id" class="form-select">
                                        <option selected="" disabled>Select Group</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-check mb-2">
                                    <input type="checkbox" id="checkDefaultmain" class="form-check-input">
                                    <label for="checkDefaultmain" class="form-check-label">Permission All</label>
                                </div>

                                <hr>
                                @foreach ($permission_groups as $groups)
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-check mb-2">
                                                <input type="checkbox" name="checkDefault" id="checkDefault"
                                                    class="form-check-input">
                                                <label for="checkDefault"
                                                    class="form-check-label">{{ $groups->group_name }}</label>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            @php
                                                $permissions = App\Models\User::getpermissionByGroupName($groups->group_name);
                                            @endphp
                                            @foreach ($permissions as $permission)
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" name="permission[]" id="checkDefault"{{$permission->id}}
                                                        class="form-check-input" value={{$permission->id}}>
                                                    <label for="checkDefault"{{$permission->id}}
                                                        class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                            <br>
                                        </div>


                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-primary me-2">Update Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script text="type/javascript">
        $('#checkDefaultmain').click(function(){
            if($(this).is(":checked")){
                $('input[type=checkbox]').prop('checked', true);
            }else{
                $('input[type=checkbox]').prop('checked', false);
            }
        })
    </script>
@endsection
