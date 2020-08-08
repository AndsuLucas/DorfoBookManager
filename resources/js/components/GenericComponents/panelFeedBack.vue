<template>
    <div class="feedBackPanel" id="feedBackPanel">
        <div v-show="hasFeedback">
            <ul>
                <li v-for="(feedback, index) in feedbackContent" :key="index">{{feedback}}</li>
            </ul>
        </div>
    </div>
</template>
<script>
import Comunication from '../../Comunication.js';
export default {
    data() {
        return {
            hasFeedback: false,
            feedbackContent: [],
        }
    },
    created() {
        Comunication.$on('toggleFeedback', (feedbackContent) => {
            this.hasFeedback = true;
            this.feedbackContent[0] = feedbackContent;
        });

        Comunication.$on('pushFeedBack', (feedbackContent) => {
            this.hasFeedback = true;
            this.feedbackContent.push(feedbackContent);
        });

        setTimeout(()=> {
                this.hasFeedback = false
                this.feedbackContent = [];
        }, 6000);

    }
}
</script>
