let routes= [];

import dashboard from "./vue-routes-dashboard";
import brand from "./vue-routes-brands";
import item from "./vue-routes-items";

routes = routes.concat(dashboard);
routes = routes.concat(brand);
routes = routes.concat(item);

export default routes;
