<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-0">
        <span class="text-muted fw-light">
            پنل کاربری /کاربر ها /
        </span>
        ویرایش کاربر
    </h4>
    <div class="app-ecommerce">
        <!-- Add Product -->
        <div class="row">
            <!-- First column-->
            <div class="col-12">
                <!-- Product Information -->

                <form wire:submit.prevent="update" class="mb-3">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">ویرایش کاربر</h5>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">نام کاربری</label>
                                <input
                                    wire:model="name"
                                    class="form-control"
                                    placeholder="نام کاربری" type="text"
                                    style="background-color: unset">
                                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">شماره موبایل</label>
                                <input
                                    wire:model="mobile"
                                    class="form-control"
                                    placeholder="موبایل" type="text"
                                    style="background-color: unset">
                                <x-input-error :messages="$errors->get('mobile')" class="mt-2"/>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">آدرس</label>
                                <input
                                    wire:model="address"
                                    class="form-control"
                                    placeholder="آدرس" type="text"
                                    style="background-color: unset">
                                <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                            </div>

                        </div>
                        <br/>


                    </div>
                    <br/>
                    <div class="d-flex align-content-center flex-wrap gap-3">
                        <button  type="submit" wire:loading.attr='disabled'
                                 class="btn btn-primary waves-effect waves-light">ثبت
                        </button>
                        <div
                            class="d-flex gap-3">
                            <a href="{{route('dashboard.user-manager')}}" wire:navigate>
                                <button class="btn btn-danger waves-effect">برگشت</button>
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>




</div>



