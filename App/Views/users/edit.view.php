<?php require_once 'App/Views/includes/_header.php'?>

<div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3
                    class="text-lg font-medium leading-6 text-gray-900">
                    Personal Information</h3>
                <p
                    class="mt-1 text-sm text-gray-600">
                    Use a permanent address where
                    you can receive mail.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="/php-obscure/users/<?php echo $user->id ?>"
                method="POST">
                <?php
                    echo csrf_field();
                    echo method_field('PUT');
                ?>
                <div
                    class="shadow overflow-hidden sm:rounded-md text-gray-700">
                    <div
                        class="px-4 py-5 bg-white sm:p-6">
                        <div
                            class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-4">
                                <label
                                    for="first_name"
                                    class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text"
                                    id="first_name"
                                    name="name"
                                    value="<?php echo $user->name?>"
                                    placeholder="First name..."
                                    autocomplete="given-name"
                                    class="mt-1 w-full border px-4 py-2 rounded focus:border-indigo-500 focus:shadow-outline outline-none">
                            </div>

                            <div
                                class="col-span-6 sm:col-span-4">
                                <label
                                    for="email_address"
                                    class="block text-sm font-medium text-gray-700">Email
                                    address</label>
                                <input type="text"
                                    id="email_address"
                                    name="email"
                                    value="<?php echo $user->email?>"
                                    autocomplete="email"
                                    placeholder="email adress.."
                                    class="mt-1 w-full border px-4 py-2 rounded focus:border-indigo-500 focus:shadow-outline outline-none">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="country"
                                    class="block text-sm font-medium text-gray-700">Course</label>
                                <select
                                    id="country"
                                    name="course_name"
                                    autocomplete="country"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <?php foreach ($courses as $course): ?>
                                    <option <?php
                                        // use function
                                        echo $user->course_name == $course->name ?
                                            'selected="selected"' : '';
                                        ?> >
                                        <?php echo $course->name; ?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <!-- Use ajax to specify major per course -->
                            <div
                                class="col-span-6 sm:col-span-3">
                                <label
                                    for="country"
                                    class="block text-sm font-medium text-gray-700">Major</label>
                                <select
                                    id="country"
                                    name="course_major"
                                    autocomplete="country"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>mi arcu pretium nunc</option>
                                    <option>ultrices lorem et ligula lobortis</option>
                                    <option>erat nec consectetur</option>
                                    <option>convallis pretium portar</option>
                                    <option>sapien vehicular</option>
                                </select>
                            </div>

                            <div
                                class="col-span-6">
                                <label
                                    for="street_address"
                                    class="block text-sm font-medium text-gray-700">Street
                                    address</label>
                                <input type="text"
                                    id="street_address"
                                    name="address"
                                    value="<?php echo $user->address?>"
                                    autocomplete="street-address"
                                    class="mt-1 w-full border px-4 py-2 rounded focus:border-indigo-500 focus:shadow-outline outline-none">
                            </div>

                            <div
                                class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="city"
                                    class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text"
                                    name="city"
                                    id="city"
                                    class="mt-1 w-full border px-4 py-2 rounded focus:border-indigo-500 focus:shadow-outline outline-none">
                            </div>

                            <div
                                class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="state"
                                    class="block text-sm font-medium text-gray-700">Status</label>
                                <select
                                    name="status"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <!-- use function -->
                                    <option <?php
                                        echo $user->status == 'Pending' ?
                                            'selected="selected"' : '';
                                        ?> >
                                        Pending
                                    </option <?php
                                        echo $user->status == 'Active' ?
                                            'selected="selected"' : '';
                                        ?> >
                                    <option>Active
                                    </option>
                                    <option <?php
                                        echo $user->status == 'Inactive' ?
                                            'selected="selected"' : '';
                                        ?> >
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <div
                                class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label
                                    for="postal_code"
                                    class="block text-sm font-medium text-gray-700">Role</label>
                                <select
                                    name="role"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option <?php
                                        echo $user->role == 'Applicant' ?
                                            'selected="selected"' : '';
                                        ?> >
                                        Applicant
                                    </option>
                                    <option <?php
                                        echo $user->role == 'Member' ?
                                            'selected="selected"' : '';
                                        ?> >
                                        Member
                                    </option>
                                    <option <?php
                                        echo $user->role == 'Assistant' ?
                                            'selected="selected"' : '';
                                        ?> >
                                        Assistant
                                    </option>
                                    <option <?php
                                        echo $user->role == 'admin' ?
                                            'selected="selected"' : '';
                                        ?> >
                                        Admin
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div
                        class="px-4 py-3 bg-gray-50 sm:px-6 text-right">
                        <button type="submit"
                            class="py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update
                        </button>
                        <a href="#delete"
                        onclick="confirm('are you sure you want to delete this user?') ?
                        document.querySelector('#js-delete').submit() : ''"
                            class="py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete
                        </a>
                    </div>
                </div>
            </form>

            <form action="/php-obscure/users/<?php echo $user->id; ?>"
                id="js-delete" method="POST" class="hidden">
                <?php
                    echo csrf_field();
                    echo method_field('DELETE');
                ?>

            </form>
        </div>
    </div>
</div>
<?php require_once 'App/Views/includes/_footer.php'?>