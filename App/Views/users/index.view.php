<?php require_once 'App/Views/includes/_header.php'?>
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Name
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Course
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Role
              </th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Edit</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach($users as $user):?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">
                      <?php echo $user->name ?>
                    </div>
                    <div class="text-sm text-gray-500">
                      <?php echo $user->email ?>
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <!-- Implement sql join/ db relationship -->
                <div class="text-sm text-gray-900"><?php echo $user->course_name ?></div>
                <div class="text-sm text-gray-500"><?php echo $user->course_major ?></div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-medium rounded-full bg-yellow-500 text-gray-800">
                  <?php echo $user->status ?>
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <?php echo $user->role?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <form action="/php-obscure/users/<?php echo $user->id; ?>"
                id="js-edit" method="POST"
                class="hidden">
                <?php echo method_field('DELETE'); ?>
              </form>
                <a href="#a"
                  onclick="document.querySelector('#js-edit').submit()"
                 class="text-indigo-600 hover:text-indigo-900">Edit</a>
              </td>
            </tr>
            <?php endforeach; ?>
            <!-- More items... -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php require_once 'App/Views/includes/_footer.php'?>