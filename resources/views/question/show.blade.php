<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Show Question Detail') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:w-8/12 md:w-1/2 lg:w-5/12">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <div class="mb-6">
            <div class="flex flex-col mb-4">
              <p class="mb-2 uppercase font-bold text-lg text-grey-darkest">Question</p>
              <p class="py-2 px-3 text-grey-darkest" id="question">
                {{$question->question}}
              </p>
            </div>
            <div class="flex flex-col mb-4">
              <p class="mb-2 uppercase font-bold text-lg text-grey-darkest">Description</p>
              <p class="py-2 px-3 text-grey-darkest" id="description">
                {{$question->description}}
              </p>
            </div>
            <div class="flex">
              <p class="px-1 text-left text-grey-dark">
                {{$question->user->name}}, {{$question->updated_at}}
              </p>
            </div>
          </div>

          @include('common.errors')
          <form class="mb-6" action="{{ route('answer.store') }}" method="POST">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <div class="flex flex-col mb-4">
              <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" for="answer">New Answer</label>
              <input class="border py-2 px-3 text-grey-darkest" type="text" name="answer" id="answer">
            </div>
            <div class="flex flex-col mb-4">
              <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" for="description">Description</label>
              <input class="border py-2 px-3 text-grey-darkest" type="text" name="description" id="description">
            </div>
            <div class="flex justify-evenly">
              <a href="{{ url()->previous() }}" class="block text-center w-5/12 py-3 mt-6 font-medium tracking-widest text-black uppercase bg-gray-100 shadow-sm focus:outline-none hover:bg-gray-200 hover:shadow-none">
                Back
              </a>
              <button type="submit" class="w-5/12 py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
                Add Answer
              </button>
            </div>
          </form>

          <table class="text-center w-full border-collapse">
            <thead>
              <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-lg text-grey-dark border-b border-grey-light">Answers</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($answers as $answer)
              <tr class="hover:bg-grey-lighter">
                <td class="text-left py-4 px-6 border-b border-grey-light">
                  <a href="{{ route('follow.show', $answer->user->id) }}">
                    <p class="text-left text-grey-dark">{{$answer->user->name}}</p>
                  </a>

                  <div class="flex flex-col mb-4">
                    <p class="mb-2 uppercase font-bold text-lg text-grey-darkest">Answer</p>
                    <p class="py-2 px-3 text-grey-darkest" id="question">
                        {{$answer->answer}}
                    </p>
                  </div>
                  <div class="flex flex-col mb-4">
                    <p class="mb-2 uppercase font-bold text-lg text-grey-darkest">Description</p>
                    <p class="py-2 px-3 text-grey-darkest" id="description">
                        {{$answer->description}}
                    </p>
                  </div>
                  <div class="flex">
                    <!-- thumbsup 状態で条件分岐 -->
                    @if($answer->users()->where('user_id', Auth::id())->exists())
                    <!-- unthumbsup ボタン -->
                    <form action="{{ route('unthumbsupanswer',$answer) }}" method="POST" class="text-left">
                      @csrf
                      <button type="submit" class="flex mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-red py-1 px-2 focus:outline-none focus:shadow-outline">
                        <svg class="h-6 w-6 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="red" fill="none" stroke-linecap="round" stroke-linejoin="round"> 
                          <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M7 11v 8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />
                        </svg>
                        {{ $answer->users()->count() }}
                      </button>
                    </form>
                    @else
                    <!-- thumbsup ボタン -->
                    <form action="{{ route('thumbsupanswer',$answer) }}" method="POST" class="text-left">
                      @csrf
                      <button type="submit" class="flex mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-black py-1 px-2 focus:outline-none focus:shadow-outline">
                        <svg class="h-6 w-6 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="gray" fill="none" stroke-linecap="round" stroke-linejoin="round"> 
                          <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M7 11v 8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />
                        </svg>
                        {{ $answer->users()->count() }}
                      </button>
                    </form>
                    @endif

                    <!-- 🔽 条件分岐でログインしているユーザが投稿したanswerのみ編集ボタンと削除ボタンが表示される -->
                    @if ($answer->user_id === Auth::user()->id)
                    <!-- 更新ボタン -->
                    <form action="{{ route('answer.edit',$answer->id) }}" method="GET" class="text-left">
                      @csrf
                      <button type="submit" class="mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-white py-1 px-2 focus:outline-none focus:shadow-outline">
                        <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="black">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                      </button>
                    </form>

                    <!-- 削除ボタン -->
                    <form action="{{ route('answer.destroy',$answer->id) }}" method="POST" class="text-left">
                      @method('delete')
                      @csrf
                      <button type="submit" class="mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-white py-1 px-2 focus:outline-none focus:shadow-outline">
                        <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="black">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </form>
                    @endif
                    <div>
                      <p class="text-left text-grey-dark">{{$answer->updated_at}}</p>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>