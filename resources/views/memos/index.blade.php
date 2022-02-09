<x-app-layout>
  @section('title', 'Company Memo')

  <x-slot name="header">
    <x-page-header>
      Company Memo
    </x-page-header>
  </x-slot>

  <x-page-wrap>
    @livewire('memos.index')
    @livewire('memos.form')

    <x-focus-error />
  </x-page-wrap>
</x-app-layout>


