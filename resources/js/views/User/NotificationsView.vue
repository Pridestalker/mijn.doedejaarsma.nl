<template>
    <aside class="position-relative">
        <button class="btn" @click="showNotifications = !showNotifications" :class="notificationBubbleClass">
            <i class="fas fa-bell"></i>
        </button>
        <section class="position-absolute bg-white" v-show="showNotifications">
            <main v-if="notifications" class="p-2">
                <notification-component v-for="notification in notifications" :key="notification.id" :notification="notification" @removed="removeOne"></notification-component>
            </main>
            <aside class="p-2 border-top">
                Bekijk alle notificaties
            </aside>
        </section>
    </aside>
</template>

<script>
    import NotificationComponent from '../../components/user/notifications/NotificationComponent'
    export default {
        name: "NotificationsView",
        components: { NotificationComponent },
        data() {
            return {
                notifications: [],
                showNotifications: false
            }
        },
        methods: {
            fetchData() {
                this.$http
                    .get('/api/v1/user/notifications/unread')
                    .then((res) => {
                        this.notifications = res.data;
                    })
            },
            removeOne({id}) {
                this.notifications.splice(this.notifications.indexOf(id), 1)
            }
        },
        beforeMount() {
            this.fetchData();
        },
        computed: {
            notificationBubbleClass() {
                console.log(this.notifications);
                return {
                    'text-primary': (typeof this.notifications[0] == 'object'),
                    'text-muted': (typeof this.notifications[0] != 'object')
                }
            }
        }
    }
</script>

<style scoped>
.position-absolute {
    z-index: 10;
    width: 250px
}
</style>
