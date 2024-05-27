import { Component } from '@angular/core';
import { UserInfoComponent } from '../user-info/user-info.component';
import { UserOrdersComponent } from '../user-orders/user-orders.component';
import { EditInfoComponent } from '../edit-info/edit-info.component';

@Component({
  selector: 'app-user-profile',
  standalone: true,
  imports: [UserInfoComponent,UserOrdersComponent],
  templateUrl: './user-profile.component.html',
  styleUrl: './user-profile.component.css'
})
export class UserProfileComponent {

}
