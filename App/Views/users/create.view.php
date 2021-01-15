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
            <form action="/php-obscure/users"
                method="POST">
                <?php echo csrf_field() ?>
                <div
                    class="shadow overflow-hidden sm:rounded-md text-gray-700">
                    <div
                        class="px-4 py-5 bg-white sm:p-6">
                        <div
                            class="grid grid-cols-6 gap-6">

                            <div
                                class="col-span-6 sm:col-span-3">
                                <label
                                    for="first_name"
                                    class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text"
                                    name="first_name"
                                    id="first_name"
                                    placeholder="First name..."
                                    autocomplete="given-name"
                                    class="mt-1 border px-4 py-2 rounded focus:border-indigo-500 focus:shadow-outline outline-none">
                            </div>

                            <div
                                class="col-span-6 sm:col-span-3">
                                <label
                                    for="last_name"
                                    class="block text-sm font-medium text-gray-700">Last
                                    name</label>
                                <input type="text"
                                    name="last_name"
                                    id="last_name"
                                    placeholder="Last name..."
                                    autocomplete="family-name"
                                    class="mt-1 border px-4 py-2 rounded focus:border-indigo-500 focus:shadow-outline outline-none">
                            </div>

                            <div
                                class="col-span-6 sm:col-span-4">
                                <label
                                    for="email_address"
                                    class="block text-sm font-medium text-gray-700">Email
                                    address</label>
                                <input type="text"
                                    name="email"
                                    id="email_address"
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
                                    name="country"
                                    autocomplete="country"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <?php foreach ($courses as $course): ?>
                                    <option>
                                        <?php echo $course->name ?>
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
                                    name="country"
                                    autocomplete="country"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>mi
                                        arcu
                                        pretium
                                        nunc
                                    </option>
                                    <option>
                                        ultrices
                                        lorem et
                                        ligula
                                        lobortis
                                    </option>
                                    <option>erat
                                        nec
                                        consectetur
                                    </option>
                                    <option>massa
                                        convallis
                                        pretium
                                        portar
                                    </option>
                                    <option>sapien
                                        vehicular
                                    </option>
                                </select>
                            </div>

                            <div
                                class="col-span-6">
                                <label
                                    for="street_address"
                                    class="block text-sm font-medium text-gray-700">Street
                                    address</label>
                                <input type="text"
                                    name="address"
                                    id="street_address"
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
                                    <option>
                                        Pending
                                    </option>
                                    <option>Active
                                    </option>
                                    <option>
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
                                    <option>
                                        Applicant
                                    </option>
                                    <option>Member
                                    </option>
                                    <option>
                                        Assistant
                                    </option>
                                    <option>Admin
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div
                        class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>