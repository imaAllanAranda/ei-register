<x-app-layout>
  @section('title', 'Memo')

  <x-slot name="header">
    <x-page-header>
      Memo
    </x-page-header>
  </x-slot>

  <x-page-wrap>
    @livewire('memos.index')
    @livewire('memos.form')

    <x-focus-error />
  </x-page-wrap>
</x-app-layout>


