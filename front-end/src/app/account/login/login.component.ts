import { Component } from '@angular/core';
import {
  FormBuilder,
  FormGroup,
  FormsModule,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, CommonModule, ReactiveFormsModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css',
})
export class LoginComponent {
  loginForm: FormGroup = new FormGroup({});
  loginError: string | null = null;

  constructor(
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private router: Router
  ) {}
  ngOnInit() {
    this.loginForm = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(6)]],
    });
  }
  onSubmit() {
    if (this.loginForm.invalid) {
      return;
    }
    const { email, password } = this.loginForm.value;
    this.authService.login(email, password).subscribe(
      (response) => {
        localStorage.setItem('token', response.access_token);
        // Redirect the user to the home page
        this.router.navigate(['/home']);
      },
      (error) => {
        console.error('Login failed', error);
        // Handle specific login errors based on error response from server
        if (error.status === 401) {
          // Unauthorized error (invalid credentials)
          this.loginError = 'Invalid email or password. Please try again.';
        } else {
          // Other server errors
          this.loginError =
            'An unexpected error occurred. Please try again later.';
        }
      }
    );
  }
}
