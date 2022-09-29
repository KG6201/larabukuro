<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Question') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:w-8/12 md:w-1/2 lg:w-5/12">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          @include('common.errors')
          <form class="mb-6" action="{{ route('question.update',$question->id) }}" method="POST">
            @method('put')
            @csrf
            <input type="hidden" name="is_solved" value="{{ 0 }}">
            <div class="flex flex-col mb-4">
              <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" for="question">question</label>
              <input class="border py-2 px-3 text-grey-darkest" type="text" name="question" id="question" value="{{$question->question}}">
            </div>
            <div class="flex flex-col mb-4">
              <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" for="description">Description</label>
              <input class="border py-2 px-3 text-grey-darkest" type="text" name="description" id="description" value="{{$question->description}}">
            </div>
            <div class="flex justify-evenly">
              <a href="{{ url()->previous() }}" class="block text-center w-5/12 py-3 mt-6 font-medium tracking-widest text-black uppercase bg-gray-100 shadow-sm focus:outline-none hover:bg-gray-200 hover:shadow-none">
                Back
              </a>
              <button type="submit" class="w-5/12 py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
                Update
              </button>
            </div>
          </form>

          <form class="mb-6" action="{{ route('question.update',$question->id) }}" method="POST">
            @method('put')
            @csrf
            <input type="hidden" name="is_solved" value="{{ 1 }}">
            <input type="hidden" name="question" id="question" value="{{$question->question}}">
            <input type="hidden" name="description" id="description" value="{{$question->description}}">
            <button type="submit" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
              Solved!
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>