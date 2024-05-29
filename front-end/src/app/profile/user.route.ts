import { Routes } from '@angular/router';
import { UserViewComponent } from './user-view/user-view.component';
import { UserProfileComponent } from './user-profile/user-profile.component';



export const userRoutes: Routes = [
  {
    path: '',
    component: UserViewComponent,
    children: [
      {
        path: '',
        redirectTo: 'profile',
        pathMatch: 'full',
      },
      {
        path: 'profile',
        component: UserProfileComponent,
      }
      
    ],
  },
];
