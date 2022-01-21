<div>
  <div class="flex flex-col">
    <div class="mb-4 flex flex-col md:flex-row md:items-end md:space-x-4 space-y-2 md:space-y-0">
      <div>
        <x-jet-input type="text" placeholder="Search..." wire:model.debounce="search" />
      </div>
      @if (auth()->user()->hasPermissionTo('advisers.create'))
        <div>
          <x-jet-button type="button" wire:click="$emitTo('advisers.form', 'add')">
            Register an Adviser / Staff
          </x-jet-button>
        </div>
      @endif
    </div>

    @if ($advisers->count())
      <div class="mb-4">
        <div class="sm:hidden">
          <label for="tabs" class="sr-only">Select a tab</label>
          <select id="tabs" name="tabs"
            class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
            wire:change="$set('currentTab', $event.target.value)">
            @foreach ($tabs as $tabName => $tabLabel)
              <option {{ $tabName == $currentTab ? 'selected' : null }} value="{{ $tabName }}">
                {{ $tabLabel }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="hidden sm:inline-block">
          <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200" aria-label="Tabs">
            @foreach ($tabs as $tabName => $tabLabel)
              <a href="javascript:void(0);"
                class="{{ $tabName == $currentTab ? 'text-tblue' : 'text-shark hover:text-dsgreen' }} {{ $tabName == $firstTab ? 'rounded-l-lg' : null }} {{ $tabName == $lastTab ? 'rounded-r-lg' : null }} group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10 flex items-center"
                aria-current="page"
                wire:click="$set('currentTab', '{{ $tabName }}')">
                <span class="w-full">{{ $tabLabel }}</span>
                <span aria-hidden="true"
                  class="{{ $tabName == $currentTab ? 'bg-lmara' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
              </a>
            @endforeach
          </nav>
        </div>
      </div>
    @endif

    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 h-screen">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div
          class="shadow {{-- overflow-hidden --}} border-b border-gray-200 sm:rounded-lg bg-white divide-y divide-gray-200">
          @if ($advisers->count())
            <table class="min-w-full divide-y divide-gray-200 sm:rounded-lg">
              <thead class="bg-gray-50 sm:rounded-t-lg">
                <tr>
                  <th scope="col" class="relative px-4 py-3 sm:rounded-tl-lg">
                    <span class="sr-only">Actions</span>
                  </th>
                  <th scope="col"
                    class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
                    <x-column-sorter column="type">
                      Type
                    </x-column-sorter>
                  </th>
                  <th scope="col"
                    class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
                    <x-column-sorter column="name">
                      Name
                    </x-column-sorter>
                  </th>
                  @if ($currentTab == 'basic_information')
                    <th scope="col"
                      class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
                      <x-column-sorter column="email">
                        Email
                      </x-column-sorter>
                    </th>
                    <th scope="col"
                      class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
                      <x-column-sorter column="fsp_no">
                        FSP Number
                      </x-column-sorter>
                    </th>
                    <th scope="col"
                      class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
                      <x-column-sorter column="contact_number">
                        Contact Number
                      </x-column-sorter>
                    </th>
                    <th scope="col"
                      class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider {{ !auth()->user()->hasPermissionTo('advisers.delete')
    ? 'sm:rounded-tr-lg'
    : null }}">
                      <x-column-sorter column="status">
                        Status
                      </x-column-sorter>
                    </th>
                  @else
                    @foreach (config('services.adviser.requirements') as $requirementKey => $requirement)
                      @if ($requirementKey == $currentTab)
                        @foreach ($requirement as $subRequirementKey => $subRequirement)
                          <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider {{ $loop->last &&
!auth()->user()->hasPermissionTo('advisers.delete')
    ? 'sm:rounded-tr-lg'
    : null }}">
                            {{ $subRequirement['label'] }}
                          </th>
                        @endforeach
                      @endif
                    @endforeach
                  @endif
                  @if (auth()->user()->hasPermissionTo('advisers.delete'))
                    <th scope="col" class="relative px-4 py-3 sm:rounded-tr-lg">
                      <span class="sr-only">Delete Action</span>
                    </th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach ($advisers as $index => $adviser)
                  <tr class="{{ $index % 2 ? 'bg-gray-50' : 'bg-white' }}">
                    <td class="px-4 py-2 whitespace-nowrap text-left text-sm font-medium">
                      <x-jet-dropdown align="top-left" content-classes="py-1 bg-white divide-y divide-gray-200">
                        <x-slot name="trigger">
                          <button type="button"
                            class="text-lmara hover:text-dsgreen" title="Actions">
                            <x-heroicon-o-dots-vertical class="h-6 w-6" />
                          </button>
                        </x-slot>
                        <x-slot name="content">
                          <x-jet-dropdown-link href="javascript:void(0)"
                            wire:click="$emitTo('advisers.form', 'edit', {{ $adviser->id }})">
                            @if (auth()->user()->hasPermissionTo('advisers.update'))
                              Update
                            @else
                              View Details
                            @endif
                          </x-jet-dropdown-link>
                          @if (auth()->user()->hasPermissionTo('adviser-requirements'))
                            <x-jet-dropdown-link href="javascript:void(0)"
                              wire:click="$emitTo('advisers.requirement', 'show', {{ $adviser->id }})">
                              Requirements
                            </x-jet-dropdown-link>
                          @endif
                          @if (auth()->user()->hasPermissionTo('advisers.view-pdf'))
                            <x-jet-dropdown-link href="javascript:void(0)"
                              wire:click="showPdf({{ $adviser->id }})">
                              View PDF
                            </x-jet-dropdown-link>
                          @endif
                        </x-slot>
                      </x-jet-dropdown>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
                      {{ $adviser->type }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
                      {{ $adviser->name }}
                    </td>
                    @if ($currentTab == 'basic_information')
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
                        {{ $adviser->email }}
                      </td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
                        {{ $adviser->fsp_no ?? 'N/A' }}
                      </td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
                        {{ $adviser->contact_number }}
                      </td>
                      <td
                        class="px-4 py-2 whitespace-nowrap text-sm text-opacity-75 {{ $adviser->status_class }}">
                        {{ $adviser->status }}
                      </td>
                    @else
                      @foreach (config('services.adviser.requirements') as $requirementKey => $requirement)
                        @if ($requirementKey == $currentTab)
                          @foreach ($requirement as $subRequirementKey => $subRequirement)
                            <td
                              class="px-4 py-2 whitespace-nowrap text-sm text-opacity-75 font-medium {{ $adviser->requirementClass($requirementKey, $subRequirementKey, $adviser->requirements[$requirementKey][$subRequirementKey]) }}">
                              {{ $adviser->requirementValue($requirementKey, $subRequirementKey, $adviser->requirements[$requirementKey][$subRequirementKey]) }}
                            </td>
                          @endforeach
                        @endif
                      @endforeach
                    @endif

                    @if (auth()->user()->hasPermissionTo('advisers.delete'))
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
                        <button type="button" class="text-red-500 hover:text-red-700" title="Delete"
                          wire:click="confirmDelete({{ $adviser->id }})">
                          <x-heroicon-o-trash class="h-6 w-6" />
                        </button>
                      </td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
            </table>
            {{ $advisers->links() }}
          @else
            <p class="text-shark px-4 py-3">No available advisers.</p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <x-jet-dialog-modal wire:model="showPdf" max-width="5xl" focusable>
    <x-slot name="title">Adviser PDF</x-slot>
    <x-slot name="content">
      <iframe src="{{ $this->PdfUrl }}" class="w-full" style="height: 600px;"></iframe>
    </x-slot>
    <x-slot name="footer">
      <x-jet-secondary-button type="button" wire:click="$set('showPdf', false)">Close</x-jet-secondary-button>
    </x-slot>
  </x-jet-dialog-modal>

  <x-jet-confirmation-modal wire:model="showDelete">
    <x-slot name="title">Delete Adviser</x-slot>
    <x-slot name="content">Are you sure to delete this adviser?</x-slot>
    <x-slot name="footer">
      <x-jet-button type="button" wire:click="delete">Yes</x-jet-button>
      <x-jet-secondary-button type="button" class="ml-2" wire:click="$set('showDelete', false)">No
      </x-jet-secondary-button>
    </x-slot>
  </x-jet-confirmation-modal>
</div>
