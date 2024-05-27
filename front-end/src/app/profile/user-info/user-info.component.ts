import { Component } from '@angular/core';
import { EditInfoComponent } from '../edit-info/edit-info.component';

@Component({
  selector: 'app-user-info',
  standalone: true,
  imports: [EditInfoComponent],
  templateUrl: './user-info.component.html',
  styleUrl: './user-info.component.css'
})
export class UserInfoComponent {

}
