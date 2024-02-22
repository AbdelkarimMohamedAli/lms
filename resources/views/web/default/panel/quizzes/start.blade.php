@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
    <style>
        .selected {
            background-color: #28a745 !important; /* Bootstrap's success background color */
            color: #fff;
        }
        .hidden {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <section class="mt-40">
            <h2 class="font-weight-bold font-16 text-dark-blue">{{ $quiz->title }}</h2>
            <p class="text-gray font-14 mt-5">
                <a href="{{ $quiz->webinar->getUrl() }}" target="_blank" class="text-gray">{{ $quiz->webinar->title }}</a>
                | {{ trans('public.by') }}
                <span class="font-weight-bold">
                    <a href="{{ $quiz->creator->getProfileUrl() }}" target="_blank" class="font-14"> {{ $quiz->creator->full_name }}</a>
                </span>
            </p>

            <div class="activities-container shadow-sm rounded-lg mt-25 p-20 p-lg-35">
                <div class="row">
                    <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="/assets/default/img/activity/58.svg" width="64" height="64" alt="">
                            <strong class="font-30 font-weight-bold text-secondary mt-5">{{  $quiz->pass_mark }}/{{  $quizQuestions->sum('grade') }}</strong>
                            <span class="font-16 text-gray">{{ trans('public.min') }} {{ trans('quiz.grade') }}</span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="/assets/default/img/activity/88.svg" width="64" height="64" alt="">
                            <strong class="font-30 font-weight-bold text-secondary mt-5">{{ $attempt_count }}/{{ $quiz->attempt }}</strong>
                            <span class="font-16 text-gray">{{ trans('quiz.attempts') }}</span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="/assets/default/img/activity/47.svg" width="64" height="64" alt="">
                            <strong class="font-30 font-weight-bold text-secondary mt-5">{{ $totalQuestionsCount }}</strong>
                            <span class="font-16 text-gray">{{ trans('public.questions') }}</span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="/assets/default/img/activity/clock.svg" width="64" height="64" alt="">
                            @if(!empty($quiz->time))
                                <strong class="font-30 font-weight-bold text-secondary mt-5">
                                    <div class="d-flex align-items-center timer ltr" data-minutes-left="{{ $quiz->time }}"></div>
                                </strong>
                            @else
                                <strong class="font-30 font-weight-bold text-secondary mt-5">{{ trans('quiz.unlimited') }}</strong>
                            @endif
                            <span class="font-16 text-gray">{{ trans('quiz.remaining_time') }}</span>
                        </div>
                    </div>


                </div>
            </div>
        </section>

        <section class="mt-30 quiz-form">
            <form action="/panel/quizzes/{{ $quiz->id }}/store-result" method="post" class="">
                {{ csrf_field() }}
                <input type="hidden" name="quiz_result_id" value="{{ $newQuizStart->id }}" class="form-control" placeholder=""/>
                <input type="hidden" name="attempt_number" value="{{ $attempt_count }}" class="form-control" placeholder=""/>

                <div class="row">
        <!-- Question Column -->
        <div class="col-md-6">
            @foreach($quizQuestions as $question)
                <div class="row mb-2">
                    <div class="col-12">
                        <button id="{{ $question->id }}1" type="button" class="btn btn-outline-primary questionBtn">{{ $question->title }}</button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Answer Column -->
        <div class="col-md-6">
            @foreach($quizQuestions as $question)
                <div class="row mb-2">
                    @foreach($question->quizzesQuestionsAnswers as $answer)
                        <div class="col-12">
                            <button id="{{ $question->id.$answer->correct}}" type="button" class="btn btn-outline-primary answerBtn">{{ $answer->title }}</button>
                        </div>
                    @endforeach
                </div>
            @endforeach  
        </div>
    </div>

                
                
                                                                

                    
            </form>
        </section>

    </div>
@endsection

@push('scripts_bottom')
<script>

    //////////////////////////////////////////////////////////////////
    const questionButtons = document.querySelectorAll('.questionBtn');

    // Add click event listener to each question button
    questionButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove 'selected' class from all question buttons
            questionButtons.forEach(btn => btn.classList.remove('selected'));
            // Add 'selected' class to the clicked question button
            button.classList.add('selected');
        });
    });

    // Get all answer buttons
    const answerButtons = document.querySelectorAll('.answerBtn');

    // Add click event listener to each answer button
    answerButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove 'selected' class from all answer buttons
            answerButtons.forEach(btn => btn.classList.remove('selected'));
            // Add 'selected' class to the clicked answer button
            button.classList.add('selected');

            
        });
    });
    
    

    
    // const selectedInputs = document.getElementsByClassName('selected');
    // for (const input of selectedInputs) {
    //     console.log('Selected Input Element:', input);
    // }

    // const selectedElements = document.getElementsByClassName('selected');

    // for (const element of selectedElements) {
    //     console.log('Selected Element:', element);
    // }

    // const elementToHide1 = document.getElementById('elementToHide1');
    // const elementToHide2 = document.getElementById('elementToHide2');

    // if (elementToHide1 && elementToHide2) {
    //     // Hide the elements with specific IDs
    //     elementToHide1.classList.add('hidden');
    //     elementToHide2.classList.add('hidden');
    // }

    // if (document.getElementById('button1').classList.contains('selected') &&
    //         document.getElementById('button2').classList.contains('selected')) {
    //         // Hide the elements with specific IDs
    //         document.getElementById('elementToHide1').classList.add('hidden');
    //         document.getElementById('elementToHide2').classList.add('hidden');
    // }

</script>
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/jquery.simple.timer/jquery.simple.timer.js"></script>
    <script src="/assets/default/js/parts/quiz-start.min.js"></script>
@endpush
