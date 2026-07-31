#include <bits/stdc++.h>
using namespace std;

int LCS (string s1, int n, string s2, int m) {
    if (n == 0 || m == 0) return 0;
    
    if (s1[n-1] == s2[m-1]) return 1 + LCS(s1, n-1, s2, m-1);
    
    return max(LCS(s1, n-1, s2, m), LCS(s1, n, s2, m-1));
}

int LCS_memo (string s1, int n, string s2, int m, vector<vector<int> >& dp) {
    if (n == 0 || m == 0) return 0;
    
    if (dp[n][m] != -1) return dp[n][m];
    
    if (s1[n-1] == s2[m-1]) return dp[n][m] = 1 + LCS_memo(s1, n-1, s2, m-1, dp);
    
    return dp[n][m] = max(LCS_memo(s1, n-1, s2, m, dp), LCS_memo(s1, n, s2, m-1, dp));
}

int LCS_tab (string s1, int n, string s2, int m, vector<vector<int> >& dp) {
    for (int i=1; i<=n; i++) {
        for (int j=1; j<=m; j++) {
            if (s1[i-1] == s2[j-1])
                dp[i][j] = 1 + dp[i-1][j-1];
            else
                dp[i][j] = max(dp[i-1][j], dp[i][j-1]);
        }
    }
    return dp[n][m];
}

int main() {
	string s1 = "bd", s2 = "abcd";
	int n = s1.length(), m = s2.length();
	
	vector<vector<int> > dp;
	
	// for memoization - comment out the 
	dp.resize(n+1, vector<int>(m+1, -1));
	
	// for tabulation
	//dp.resize(n+1, vector<int>(m+1, 0));
	
	cout << LCS_memo(s1, n, s2, m, dp) << endl;
	
	return 0;
}