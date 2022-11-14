import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'

import { InertiaProgress } from '@inertiajs/progress'
import "./Helpers/InitNumber";

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .mixin({
        methods: {
          hasAnyPermission(permissions) {
            let allPermissions = this.$page.props.auth.permissions;

            // return allPermissions.find(perm => permissions.includes(perm)) !== undefined;
            let hasPermission = false;
            permissions.forEach(function(item){
              if(allPermissions[item]) hasPermission = true;     
            });

            return hasPermission;
          },

          formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          }
        }
      })
      .use(plugin)
      .mount(el)
  },
});

InertiaProgress.init();