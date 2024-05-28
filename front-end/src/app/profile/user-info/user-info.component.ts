import { Component } from '@angular/core';
import { EditInfoComponent } from '../edit-info/edit-info.component';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-user-info',
  standalone: true,
  imports: [EditInfoComponent],
  templateUrl: './user-info.component.html',
  styleUrl: './user-info.component.css',
})
export class UserInfoComponent {
  currentUser: any;

  constructor(private router: Router, private authService: AuthService) {}
  ngOnInit(): void {
    this.authService.getCurrentUser().subscribe((user) => {
      this.currentUser = user;
      console.log(this.currentUser.image_url)
    });
  }
}
