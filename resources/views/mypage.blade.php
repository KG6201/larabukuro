<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('My Question and Answer') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:w-10/12 md:w-8/10 lg:w-8/12">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <table class="text-center w-full border-collapse">
            <thead>
              <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-lg text-grey-dark border-b border-grey-light">question</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($questions as $question)
              <tr class="hover:bg-grey-lighter">
                <td class="py-4 px-6 border-b border-grey-light">
                  <!-- 詳細画面へのリンク -->
                  <a href="{{ route('question.show',$question->id) }}">
                    <h3 class="text-left font-bold text-lg text-grey-dark">{{$question->question}}</h3>
                  </a>
                  <div class="flex">
                    @if($question->questionAnswers()->exists())
                      <svg class="h-6 w-6 mr-2 ml-2 text-black mt-1"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                      </svg>
                      {{ $question->questionAnswers()->count() }}
                    @else
                      <svg class="h-6 w-6 mr-2 ml-2 text-gray mt-1"  fill="none" viewBox="0 0 24 24" stroke="gray">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                      </svg>
                      {{ $question->questionAnswers()->count() }}
                    @endif

                    <!-- thumbsup 状態で条件分岐 -->
                    @if($question->users()->where('user_id', Auth::id())->exists())
                    <!-- unthumbsup ボタン -->
                    <form action="{{ route('unthumbsup',$question) }}" method="POST" class="text-left">
                      @csrf
                      <button type="submit" class="flex mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-red py-1 px-2 focus:outline-none focus:shadow-outline">
                        <svg class="h-6 w-6 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="red" fill="none" stroke-linecap="round" stroke-linejoin="round"> 
                          <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M7 11v 8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />
                        </svg>
                        {{ $question->users()->count() }}
                      </button>
                    </form>
                    @else
                    <!-- thumbsup ボタン -->
                    <form action="{{ route('thumbsup',$question) }}" method="POST" class="text-left">
                      @csrf
                      <button type="submit" class="flex mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-black py-1 px-2 focus:outline-none focus:shadow-outline">
                        <svg class="h-6 w-6 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="gray" fill="none" stroke-linecap="round" stroke-linejoin="round"> 
                          <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M7 11v 8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />
                        </svg>
                        {{ $question->users()->count() }}
                      </button>
                    </form>
                    @endif

                    @if (!($question->is_solved))
                      <!-- 🔽 条件分岐でログインしているユーザが投稿したquestionのみ編集ボタンと削除ボタンが表示される -->
                      @if ($question->user_id === Auth::user()->id)
                      <!-- 更新ボタン -->
                      <form action="{{ route('question.edit',$question->id) }}" method="GET" class="text-left">
                        @csrf
                        <button type="submit" class="mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-white py-1 px-2 focus:outline-none focus:shadow-outline">
                          <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                          </svg>
                        </button>
                      </form>
                      <!-- 削除ボタン -->
                      <form action="{{ route('question.destroy',$question->id) }}" method="POST" class="text-left">
                        @method('delete')
                        @csrf
                        <button type="submit" class="mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-white py-1 px-2 focus:outline-none focus:shadow-outline">
                          <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </button>
                      </form>
                      @endif
                    @endif
                    <div>
                      <p class="text-left text-grey-dark">{{$question->updated_at}}</p>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <x-dropdown-link/>

          <table class="text-center w-full border-collapse">
            <thead>
              <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-lg text-grey-dark border-b border-grey-light">answer</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($answers as $answer)
              <tr class="hover:bg-grey-lighter">
                <td class="text-left py-4 px-6 border-b border-grey-light">
                  <!-- 詳細画面へのリンク -->
                  <a href="{{ route('question.show',$answer->question_id) }}">
                    <h3 class="text-left font-bold text-lg text-grey-dark">{{$answer->answer}}</h3>
                  </a>
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

                    @if (!in_array($answer->question_id, $solved_question_ids))
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