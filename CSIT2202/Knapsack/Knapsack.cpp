#include <bits/stdc++.h>
using namespace std;

int knapsack(int W, int wt[], int val[], int n) {

    int dp[n + 1][W + 1];

    // Initialize first row and first column
    for (int i = 0; i <= n; i++)
        dp[i][0] = 0;

    for (int j = 0; j <= W; j++)
        dp[0][j] = 0;

    // Fill DP table
    for (int i = 1; i <= n; i++) {
        for (int w = 1; w <= W; w++) {

            // If current item can be included
            if (wt[i - 1] <= w) {
                dp[i][w] = max(
                    val[i - 1] + dp[i - 1][w - wt[i - 1]], // Take
                    dp[i - 1][w]                           // Don't take
                );
            }
            else {
                dp[i][w] = dp[i - 1][w]; // If cannot be included, just keep the previous value
            }
        }
    }

    return dp[n][W];
}

int main() {

    int wt[] = {1, 3, 4, 5};
    int val[] = {1, 4, 5, 7};

    int W = 7;
    int n = 4;

    cout << "Maximum Value = "
         << knapsack(W, wt, val, n);

    return 0;
}