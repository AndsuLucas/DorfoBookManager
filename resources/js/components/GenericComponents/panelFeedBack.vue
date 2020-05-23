<template>
    <div class="feedBackPanel" id="feedBackPanel">
        <div v-show="hasFeedback">
            <p>{{feedbackContent}}</p>
        </div>
    </div>
</template>
<script>
import Comunication from '../../Comunication.js';
export default {
    data() {
        return {
            hasFeedback: false,
            feedbackContent: "",
        }
    },
    created() {
        Comunication.$on('toggleFeedback', (feedbackContent) => {
            this.hasFeedback = true;
            this.feedbackContent = feedbackContent;
            
            setTimeout(()=> {
                this.hasFeedback = false;
            }, 4500);
        });
    }
}
</script>