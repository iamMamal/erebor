<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-0">
        <span class="text-muted fw-light">
            پنل کاربری /
        </span>
        مشاهده کاربران ثبت نام کرده
    </h4>
    <div class="card">
        <h5 class="card-header text-lg">تمامی کاربران</h5>
        <div class="card-datatable text-nowrap">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
                    <div id="DataTables_Table_1_filter" class="dataTables_filter">
                        <label>جستجو:<input type="text" wire:model.live.debounce.300ms="search" placeholder=" بر اساس شماره موبایل..."
                                            style="background: unset"></label>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="dt-complex-header table table-bordered dataTable no-footer" id="DataTables_Table_1"
                           aria-describedby="DataTables_Table_1_info">
                        <thead>
                        <tr>
                            <th rowspan="1" class="sorting sorting_asc" tabindex="0"
                                colspan="1"
                            >شماره
                            </th>
                            <th colspan="5" rowspan="1">اطلاعات</th>
                            <th colspan="2" rowspan="1">عملیات</th>
                            <th colspan="4" rowspan="1">تنظیمات</th>

                        </tr>
                        <tr>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1">
                                #
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1">
                                شماره موبایل
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1">
                                نام کاربر
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            >آدرس
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            >امتیاز
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            >تاریخ ثبت نام
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            >تعداد در خواست تخلیه
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            >تعداد در خواست پکیج
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            >وضعیت
                            </th>


                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            >تغییر وضعیت
                            </th>
                            <th class="text-center" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            >حذف کاربر
                            </th>
                            <th class="text-center" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            >ویرایش کاربر
                            </th>

                        </tr>
                        </thead>
                        <tbody >
                        @forelse($users as $user)
                            <tr class="odd" wire:key="{{ $user->id }}">
                                <td class="sorting_1">{{$user->id}}</td>
                                <td>{{$user->mobile}}
                                <td>{{ $user->name }} </td>
                                <td>{{$user->address }}</td>
                                <td>0</td>
                                <td>{{jalaliAgo($user->created_at)}}</td>
                                <td>0</td>
                                <td>0</td>
                                <td>
                                  <span class="{{ $user->is_blocked ? 'text-red-600' : 'text-green-500' }}">
                                    {{ $user->is_blocked ? 'بلاک شده' :'عادی'   }}
                                 </span>
                                </td>
                                <td>
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleFormControlSelect1">انتخاب تغییر
                                            وضعیت</label>

                                        <select wire:model="status.{{ $user->id }}" wire:change="updateStatus({{ $user->id }})" style="background: unset" class="form-select">
                                            <option value="0">عادی</option>
                                            <option value="1">بلاک شده</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button wire:click.prevent="deleteConfirmation({{ $user->id }})" class="btn btn-outline-dribbble ">حذف</button>
                                </td>
                                <td class="text-center">
                                    <button wire:navigate href="{{ route('dashboard.edit-user', ['id' => $user->id]) }}" class="btn btn-outline-google-plus">ویرایش</button>
                                </td>
                            </tr>
                        @empty
                            <p>اطلاعات وارد کنید ، داده بدهید تا این جداول فعال بشوند</p>
                        @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="footer">
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
