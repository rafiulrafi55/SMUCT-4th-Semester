#include <bits/stdc++.h>
using namespace std;

int fib (int n) {
    if (n <= 1)
        return n;
        
    return fib(n-1) + fib(n-2);
}

int fib_memo (int n, vector<int>& dp) {
    if (n <= 1)
        return n;
        
    if (dp[n] != -1)
        return dp[n];
        
    return dp[n] = fib_memo(n-1, dp) + fib_memo(n-2, dp);
}

int fib_tab (int n, vector<int>& dp) {
    dp[0] = 0;
    dp[1] = 1;
    
    for (int i=2; i<=n; i++)
        dp[i] = dp[i-1] + dp[i-2];
        
    return dp[n];
}

int main() {
	
	int n = 10;
	
	vector<int> dp(n+1, -1);
	
	cout << fib_memo(n, dp) << endl;
	
    return 0;
}