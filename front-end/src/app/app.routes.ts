import { Routes } from '@angular/router';
import { HomeComponent } from './homePage/home/home.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { OrdersComponent } from './orders/orders.component';
import { CartComponent } from './cart/cart.component';
import { UserProfileComponent } from './profile/user-profile/user-profile.component';
import { RegisterComponent } from './account/register/register.component';
import { LoginComponent } from './account/login/login.component';
import { AuthGuard } from './guards/auth.guard';
import { DashboardComponent } from './dashboard/dashboard.component';
import { AdminsComponent } from './dashboard/admins/admins.component';
import { UsersComponent } from './dashboard/users/users.component';
import { ProductsComponent } from './dashboard/products/products.component';
import { UserOrdersComponent } from './dashboard/user-orders/user-orders.component';
import { AddAdminFormComponent } from './dashboard/admins/add-admin-form/add-admin-form.component';
import { AddProductFormComponent } from './dashboard/products/add-product-form/add-product-form.component';
import { ShowProductComponent } from './dashboard/products/show-product/show-product.component';
import { EditProductFormComponent } from './dashboard/products/edit-product-form/edit-product-form.component';

export const routes: Routes = [
  {
    path: 'home',
    component: HomeComponent,
  },
  {
    path: '',
    redirectTo: 'home',
    pathMatch: 'full',
  },
  {
    path: 'products',
    loadChildren: () =>
      import('./products/product.route').then((m) => m.productroutes),
    canActivate: [AuthGuard],
  },
  {
    path: 'order',
    component: OrdersComponent,
  },
  {
    path: 'cart',
    component: CartComponent,
  },

  {
    path: 'profile',
    component: UserProfileComponent,
  },
  {
    path: 'registration',
    component: RegisterComponent,
  },
  {
    path: 'adminDashboard',
    component: DashboardComponent,
    children: [
      { path: 'admins', component: AdminsComponent },
      { path: 'admins/add-admin', component: AddAdminFormComponent },
      { path: 'users', component: UsersComponent },
      { path: 'products', component: ProductsComponent },
      { path: 'products/add-product', component: AddProductFormComponent },
      { path: 'products/edit-product/:id', component: EditProductFormComponent },
      { path: 'products/:id', component: ShowProductComponent },
      { path: 'orders', component: UserOrdersComponent },
    ],
  },

  { path: 'login', component: LoginComponent },
  {
    path: '**',
    component: NotFoundComponent,
  },
];
