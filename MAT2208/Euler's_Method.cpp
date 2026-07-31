#include <iostream>
#include <iomanip>
using namespace std;

// Function representing dy/dx = f(x, y)
double f(double x, double y)
{
    // Example: dy/dx = 1 - y
    return 1 - y;
}

// Function to perform Euler's Method
double eulerMethod(double x0, double y0, double h, double x)
{
    while (x0 < x)
    {
        y0 = y0 + h * f(x0, y0);
        x0 = x0 + h;
    }

    return y0;
}

int main()
{
    double x0, y0, h, x;

    cout << "Enter initial value of x (x0): ";
    cin >> x0;

    cout << "Enter initial value of y (y0): ";
    cin >> y0;

    cout << "Enter step size (h): ";
    cin >> h;

    cout << "Enter final value of x (x): ";
    cin >> x;

    double result = eulerMethod(x0, y0, h, x);

    cout << fixed << setprecision(4);
    cout << "\nApproximate value of y at x = "<< result << endl;

    return 0;
}