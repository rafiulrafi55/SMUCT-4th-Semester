#include <iostream>
#include <iomanip>
using namespace std;

int factorial(int n)
{
    int fact = 1;
    for (int i = 1; i <= n; i++)
        fact *= i;
    return fact;
}

double firstDerivative(double x, double y)
{
    return 1 - 2 * x * y;
}

double secondDerivative(double x, double y)
{
    return -2 * y - 2 * x * firstDerivative(x, y);
}

double thirdDerivative(double x, double y)
{
    return -4 * firstDerivative(x, y)
           - 2 * x * secondDerivative(x, y);
}

double fourthDerivative(double x, double y)
{
    return -6 * secondDerivative(x, y)
           - 2 * x * thirdDerivative(x, y);
}

// Taylor Series Method
double taylorSeries(double x, double y, double h)
{
    double y1 = firstDerivative(x, y);
    double y2 = secondDerivative(x, y);
    double y3 = thirdDerivative(x, y);
    double y4 = fourthDerivative(x, y);

    return y + h*y1
             + (h*h/factorial(2))*y2
             + (h*h*h/factorial(3))*y3
             + (h*h*h*h/factorial(4))*y4;
}

int main()
{
    double x0, y0, h;

    cout << "Enter x0: ";
    cin >> x0;

    cout << "Enter y0: ";
    cin >> y0;

    cout << "Enter step size (h): ";
    cin >> h;

    double result = taylorSeries(x0, y0, h);

    cout << fixed << setprecision(4);
    cout << "\nApproximate value of y(x+h) = " << result << endl;

    return 0;
}