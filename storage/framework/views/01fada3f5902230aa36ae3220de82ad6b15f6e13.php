<?php $__env->startPush('styles_top'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <section class="mt-40">
            <h2 class="font-weight-bold font-16 text-dark-blue"><?php echo e($quiz->title); ?></h2>
            <p class="text-gray font-14 mt-5">
                <a href="<?php echo e($quiz->webinar->getUrl()); ?>" target="_blank" class="text-gray"><?php echo e($quiz->webinar->title); ?></a>
                | <?php echo e(trans('public.by')); ?>

                <span class="font-weight-bold">
                    <a href="<?php echo e($quiz->creator->getProfileUrl()); ?>" target="_blank" class="font-14"> <?php echo e($quiz->creator->full_name); ?></a>
                </span>
            </p>

            <div class="activities-container shadow-sm rounded-lg mt-25 p-20 p-lg-35">
                <div class="row">
                    <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="/assets/default/img/activity/58.svg" width="64" height="64" alt="">
                            <strong class="font-30 font-weight-bold text-secondary mt-5"><?php echo e($quiz->pass_mark); ?>/<?php echo e($quizQuestions->sum('grade')); ?></strong>
                            <span class="font-16 text-gray"><?php echo e(trans('public.min')); ?> <?php echo e(trans('quiz.grade')); ?></span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="/assets/default/img/activity/88.svg" width="64" height="64" alt="">
                            <strong class="font-30 font-weight-bold text-secondary mt-5"><?php echo e($attempt_count); ?>/<?php echo e($quiz->attempt); ?></strong>
                            <span class="font-16 text-gray"><?php echo e(trans('quiz.attempts')); ?></span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="/assets/default/img/activity/47.svg" width="64" height="64" alt="">
                            <strong class="font-30 font-weight-bold text-secondary mt-5"><?php echo e($totalQuestionsCount); ?></strong>
                            <span class="font-16 text-gray"><?php echo e(trans('public.questions')); ?></span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="/assets/default/img/activity/clock.svg" width="64" height="64" alt="">
                            <?php if(!empty($quiz->time)): ?>
                                <strong class="font-30 font-weight-bold text-secondary mt-5">
                                    <div class="d-flex align-items-center timer ltr" data-minutes-left="<?php echo e($quiz->time); ?>"></div>
                                </strong>
                            <?php else: ?>
                                <strong class="font-30 font-weight-bold text-secondary mt-5"><?php echo e(trans('quiz.unlimited')); ?></strong>
                            <?php endif; ?>
                            <span class="font-16 text-gray"><?php echo e(trans('quiz.remaining_time')); ?></span>
                        </div>
                    </div>


                </div>
            </div>
        </section>

        <section class="mt-30 quiz-form">
            <form action="/panel/quizzes/<?php echo e($quiz->id); ?>/store-result" method="post" class="">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="quiz_result_id" value="<?php echo e($newQuizStart->id); ?>" class="form-control" placeholder=""/>
                <input type="hidden" name="attempt_number" value="<?php echo e($attempt_count); ?>" class="form-control" placeholder=""/>

                <div class="row">
        <!-- Question Column -->
        <div class="col-md-6">
            <?php $__currentLoopData = $quizQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row mb-2">
                    <div class="col-12">
                        <button id="<?php echo e($question->id); ?>1" type="button" class="btn btn-outline-primary questionBtn"><?php echo e($question->title); ?></button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Answer Column -->
        <div class="col-md-6">
            <?php $__currentLoopData = $quizQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row mb-2">
                    <?php $__currentLoopData = $question->quizzesQuestionsAnswers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-12">
                            <button id="<?php echo e($question->id.$answer->correct); ?>" type="button" class="btn btn-outline-primary answerBtn"><?php echo e($answer->title); ?></button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
        </div>
    </div>

                
                
                                                                

                    
            </form>
        </section>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make(getTemplate().'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abdel\Downloads\archiveXgOhQ\resources\views/web/default/panel/quizzes/start.blade.php ENDPATH**/ ?>